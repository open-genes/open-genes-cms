<?php

namespace app\models\repositories;

use app\models\CommentCause;
use app\models\Gene;
use app\models\GeneToCommentCause;

class GeneToCommentCauseRepository
{
    public function saveFromCriteria(Gene $gene, string $ccName): void {
        if ($commentCause = CommentCause::find()
            ->where(['name_en' => $ccName])
            ->one()) {
            if (GeneToCommentCause::find()
                ->where([
                    'gene_id' => $gene->id,
                    'comment_cause_id' => $commentCause->id
                ])
                ->one()) {
                $gene->isHidden = 0;
                $gene->save();
            } else {
                $geneToCommentCause = new GeneToCommentCause();
                $geneToCommentCause->gene_id = $gene->id;
                $geneToCommentCause->comment_cause_id = $commentCause->id;
                $geneToCommentCause->save();
            }
        }
    }
}