<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

/**
 * Disease represents the model behind the search form of `app\models\common\Disease`.
 */
class Disease extends \app\models\common\Disease
{

    private const ROOT_ICD_CATEGORY = '2019';
    private $icdChildrenDiseases = [];

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'omim_id' => 'Omim ID',
            'name_ru' => Yii::t('common', 'Name Ru'),
            'name_en' => Yii::t('common', 'Name En'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'icd_code' => Yii::t('common', 'ICD code'),
            'parent_icd_code' => Yii::t('common', 'Parent ICD code'),
            'icd_name_en' => Yii::t('common', 'Name in ICD code En'),
            'icd_name_ru' => Yii::t('common', 'Name in ICD code Ru'),
            'icd_code_visible' => Yii::t('common', 'ICD code visible'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function beforeSave($insert)
    {
        $this->parent_icd_code = trim($this->parent_icd_code);
        $this->icd_code_visible = trim($this->icd_code_visible);
        $this->icd_code = trim($this->icd_code);
        $this->omim_id = trim($this->omim_id);
        return parent::beforeSave($insert);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'omim_id' => $this->omim_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'icd_code', $this->icd_code])
            ->andFilterWhere(['like', 'parent_icd_code', $this->parent_icd_code])
            ->andFilterWhere(['like', 'icd_name_en', $this->icd_name_en])
            ->andFilterWhere(['like', 'icd_code_visible', $this->icd_code_visible])
            ->andFilterWhere(['like', 'icd_name_ru', $this->icd_name_ru]);

        return $dataProvider;
    }

    public static function findAllAsArray()
    {
        $result = [];
        $diseases = self::find()->all();
        foreach ($diseases as $disease) {
            $result[$disease->id] = $disease->name_ru ?: $disease->name_en;
        }

        return $result;
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneToDiseases()
            ->select('gene_id')->distinct()->column();
    }

    public function getIcdParentCategories()
    {
        return $this->getIcdParentCategoriesRecursive($this->parent_icd_code, [$this->icd_code => $this->icd_code . ' ' . $this->icd_name_en]);
    }

    public function getIcdCategoryByLevel($level)
    {
        $categories = $this->getIcdParentCategories();
        if(isset(array_keys($categories)[count($categories) - ($level)])) {
            return array_keys($categories)[count($categories) - ($level)];

        } else {
            throw new Exception('No parent category for ' . $this->icd_code);
        }
    }

    private function getIcdParentCategoriesRecursive($parentIcdCode, $icdCategories = [])
    {
        $parentIcd = Disease::find()->where(['icd_code' => $parentIcdCode])->one();
        if ($parentIcd && $parentIcd->icd_name_en) {
            $icdCategories[$parentIcd->icd_code] = $parentIcd->icd_code . ' ' . $parentIcd->icd_name_en;
            if ($parentIcd->parent_icd_code) {
                $icdCategories = $this->getIcdParentCategoriesRecursive($parentIcd->parent_icd_code, $icdCategories);
            }
        }
        return $icdCategories;
    }

    public static function getIcdCategoriesSlice($depth = 1)
    {
        $parentCategories = [self::ROOT_ICD_CATEGORY];
        $categories = $result = [];
        for ($i = 0; $i < $depth; $i++) {
            $categories = Disease::find()
                ->select('icd_code')
                ->where(['parent_icd_code' => $parentCategories])
                ->column();
            if($categories) {
                $parentCategories = $categories;
            }
        }

        $categories = Disease::find()->where(['icd_code' => $categories])->all();

        foreach ($categories as $category) {
            $result[$category->icd_code] = $category->icd_name_en;
        }

        return $result;
    }

    public function getDiseasesForIcdCategoriesTree()
    {
        return $this->getChildrenDiseasesForIcdRecursive($this->icd_code);
    }

    private function getChildrenDiseasesForIcdRecursive($rootIcdCategory)
    {
        if ($rootIcdCategory) {
            $icdChildrenCategories = Disease::find()
                ->select(['icd_code', 'name_en', 'icd_name_en', 'omim_id'])
                ->where(['parent_icd_code' => $rootIcdCategory])->asArray()->all();

            foreach ($icdChildrenCategories as $category) {
                if(isset($category['name_en'])) {
                    $this->icdChildrenDiseases[$category['omim_id']] = $category['name_en'];
                }
                $this->getChildrenDiseasesForIcdRecursive($category['icd_code']);
            }
            unset($icdChildrenCategories);
        }
        return $this->icdChildrenDiseases;
    }
}
