<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200302_190414_early_taxon
 */
class m200302_190414_early_taxon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('taxon', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('gene', 'taxon_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('gene_taxon', 'gene', 'taxon_id', 'taxon', 'id');

        $this->execute('insert into taxon (id, name_en) values (1, "Amniota");
insert into taxon (id, name_en) values (2, "Bilateria");
insert into taxon (id, name_en) values (3, "Boreoeutheria");
insert into taxon (id, name_en) values (4, "Catarrhini");
insert into taxon (id, name_en) values (5, "Eukaryota");
insert into taxon (id, name_en) values (6, "Euteleostomi");
insert into taxon (id, name_en) values (7, "Opisthokonta");
insert into taxon (id, name_en) values (8, "Tetrapoda");');

        $this->execute('
UPDATE gene set taxon_id=6 where symbol="A2M";
UPDATE gene set taxon_id=6 where symbol="ABL1";
UPDATE gene set taxon_id=2 where symbol="ADCY5";
UPDATE gene set taxon_id=8 where symbol="AGPAT2";
UPDATE gene set taxon_id=8 where symbol="AGTR1";
UPDATE gene set taxon_id=2 where symbol="AIFM1";
UPDATE gene set taxon_id=2 where symbol="AKT1";
UPDATE gene set taxon_id=5 where symbol="APEX1";
UPDATE gene set taxon_id=3 where symbol="APOC3";
UPDATE gene set taxon_id=8 where symbol="APOE";
UPDATE gene set taxon_id=2 where symbol="APP";
UPDATE gene set taxon_id=6 where symbol="APTX";
UPDATE gene set taxon_id=8 where symbol="AR";
UPDATE gene set taxon_id=7 where symbol="ARHGAP1";
UPDATE gene set taxon_id=2 where symbol="ARNTL";
UPDATE gene set taxon_id=6 where symbol="ATF2";
UPDATE gene set taxon_id=6 where symbol="ATM";
UPDATE gene set taxon_id=5 where symbol="ATP5O";
UPDATE gene set taxon_id=6 where symbol="ATR";
UPDATE gene set taxon_id=1 where symbol="BAK1";
UPDATE gene set taxon_id=6 where symbol="BAX";
UPDATE gene set taxon_id=8 where symbol="BCL2";
UPDATE gene set taxon_id=6 where symbol="BDNF";
UPDATE gene set taxon_id=6 where symbol="BLM";
UPDATE gene set taxon_id=6 where symbol="BMI1";
UPDATE gene set taxon_id=1 where symbol="BRCA1";
UPDATE gene set taxon_id=1 where symbol="BRCA2";
UPDATE gene set taxon_id=6 where symbol="BSCL2";
UPDATE gene set taxon_id=5 where symbol="BUB1B";
UPDATE gene set taxon_id=5 where symbol="BUB3";
UPDATE gene set taxon_id=6 where symbol="C1QA";
UPDATE gene set taxon_id=6 where symbol="CACNA1A";
UPDATE gene set taxon_id=5 where symbol="CAT";
UPDATE gene set taxon_id=5 where symbol="CCNA2";
UPDATE gene set taxon_id=5 where symbol="CDC42";
UPDATE gene set taxon_id=2 where symbol="CDK1";
UPDATE gene set taxon_id=5 where symbol="CDK7";
UPDATE gene set taxon_id=3 where symbol="CDKN1A";
UPDATE gene set taxon_id=6 where symbol="CDKN2A";
UPDATE gene set taxon_id=1 where symbol="CDKN2B";
UPDATE gene set taxon_id=6 where symbol="CEBPA";
UPDATE gene set taxon_id=8 where symbol="CEBPB";
UPDATE gene set taxon_id=6 where symbol="CETP";
UPDATE gene set taxon_id=7 where symbol="CHEK2";
UPDATE gene set taxon_id=2 where symbol="CISD2";
UPDATE gene set taxon_id=6 where symbol="CLOCK";
UPDATE gene set taxon_id=6 where symbol="CLU";
UPDATE gene set taxon_id=6 where symbol="CNR1";
UPDATE gene set taxon_id=7 where symbol="COQ7";
UPDATE gene set taxon_id=6 where symbol="CREB1";
UPDATE gene set taxon_id=6 where symbol="CREBBP";
UPDATE gene set taxon_id=5 where symbol="CSNK1E";
UPDATE gene set taxon_id=3 where symbol="CTF1";
UPDATE gene set taxon_id=6 where symbol="CTGF";
UPDATE gene set taxon_id=2 where symbol="CTNNB1";
UPDATE gene set taxon_id=6 where symbol="DBN1";
UPDATE gene set taxon_id=8 where symbol="DDIT3";
UPDATE gene set taxon_id=5 where symbol="DGAT1";
UPDATE gene set taxon_id=3 where symbol="DLL3";
UPDATE gene set taxon_id=6 where symbol="E2F1";
UPDATE gene set taxon_id=5 where symbol="EEF1A1";
UPDATE gene set taxon_id=6 where symbol="EEF1E1";
UPDATE gene set taxon_id=5 where symbol="EEF2";
UPDATE gene set taxon_id=6 where symbol="EFEMP1";
UPDATE gene set taxon_id=6 where symbol="EGF";
UPDATE gene set taxon_id=6 where symbol="EGFR";
UPDATE gene set taxon_id=6 where symbol="EGR1";
UPDATE gene set taxon_id=1 where symbol="EIF5A2";
UPDATE gene set taxon_id=4 where symbol="ELN";
UPDATE gene set taxon_id=3 where symbol="EMD";
UPDATE gene set taxon_id=6 where symbol="EP300";
UPDATE gene set taxon_id=6 where symbol="EPOR";
UPDATE gene set taxon_id=6 where symbol="EPS8";
UPDATE gene set taxon_id=6 where symbol="ERBB2";
UPDATE gene set taxon_id=5 where symbol="ERCC1";
UPDATE gene set taxon_id=5 where symbol="ERCC2";
UPDATE gene set taxon_id=5 where symbol="ERCC3";
UPDATE gene set taxon_id=5 where symbol="ERCC4";
UPDATE gene set taxon_id=1 where symbol="ERCC5";
UPDATE gene set taxon_id=6 where symbol="ERCC6";
UPDATE gene set taxon_id=5 where symbol="ERCC8";
UPDATE gene set taxon_id=6 where symbol="ESR1";
UPDATE gene set taxon_id=6 where symbol="FAS";
UPDATE gene set taxon_id=5 where symbol="FEN1";
UPDATE gene set taxon_id=3 where symbol="FGF21";
UPDATE gene set taxon_id=6 where symbol="FGF23";
UPDATE gene set taxon_id=6 where symbol="FGFR1";
UPDATE gene set taxon_id=6 where symbol="FLT1";
UPDATE gene set taxon_id=6 where symbol="FOS";
UPDATE gene set taxon_id=6 where symbol="FOXM1";
UPDATE gene set taxon_id=6 where symbol="FOXO1";
UPDATE gene set taxon_id=6 where symbol="FOXO3";
UPDATE gene set taxon_id=6 where symbol="FOXO4";
UPDATE gene set taxon_id=7 where symbol="GCLC";
UPDATE gene set taxon_id=2 where symbol="GCLM";
UPDATE gene set taxon_id=2 where symbol="GDF11";
UPDATE gene set taxon_id=4 where symbol="GH1";
UPDATE gene set taxon_id=6 where symbol="GHR";
UPDATE gene set taxon_id=3 where symbol="GHRH";
UPDATE gene set taxon_id=6 where symbol="GHRHR";
UPDATE gene set taxon_id=6 where symbol="GPX1";
UPDATE gene set taxon_id=5 where symbol="GPX4";
UPDATE gene set taxon_id=2 where symbol="GRB2";
UPDATE gene set taxon_id=6 where symbol="GRN";
UPDATE gene set taxon_id=5 where symbol="GSK3A";
UPDATE gene set taxon_id=5 where symbol="GSK3B";
UPDATE gene set taxon_id=5 where symbol="GSR";
UPDATE gene set taxon_id=5 where symbol="GSS";
UPDATE gene set taxon_id=3 where symbol="GSTA4";
UPDATE gene set taxon_id=6 where symbol="GSTP1";
UPDATE gene set taxon_id=5 where symbol="GTF2H2";
UPDATE gene set taxon_id=5 where symbol="H2AFX";
UPDATE gene set taxon_id=6 where symbol="HBP1";
UPDATE gene set taxon_id=5 where symbol="HDAC1";
UPDATE gene set taxon_id=5 where symbol="HDAC2";
UPDATE gene set taxon_id=5 where symbol="HDAC3";
UPDATE gene set taxon_id=7 where symbol="HELLS";
UPDATE gene set taxon_id=6 where symbol="HESX1";
UPDATE gene set taxon_id=6 where symbol="HIC1";
UPDATE gene set taxon_id=6 where symbol="HIF1A";
UPDATE gene set taxon_id=6 where symbol="HMGB1";
UPDATE gene set taxon_id=2 where symbol="HMGB2";
UPDATE gene set taxon_id=6 where symbol="HOXB7";
UPDATE gene set taxon_id=6 where symbol="HOXC4";
UPDATE gene set taxon_id=6 where symbol="HRAS";
UPDATE gene set taxon_id=6 where symbol="HSF1";
UPDATE gene set taxon_id=5 where symbol="HSP90AA1";
UPDATE gene set taxon_id=5 where symbol="HSPA1A";
UPDATE gene set taxon_id=5 where symbol="HSPA1B";
UPDATE gene set taxon_id=5 where symbol="HSPA8";
UPDATE gene set taxon_id=5 where symbol="HSPA9";
UPDATE gene set taxon_id=5 where symbol="HSPD1";
UPDATE gene set taxon_id=2 where symbol="HTRA2";
UPDATE gene set taxon_id=6 where symbol="HTT";
UPDATE gene set taxon_id=3 where symbol="IFNB1";
UPDATE gene set taxon_id=6 where symbol="IGF1";
UPDATE gene set taxon_id=2 where symbol="IGF1R";
UPDATE gene set taxon_id=6 where symbol="IGF2";
UPDATE gene set taxon_id=6 where symbol="IGFBP2";
UPDATE gene set taxon_id=6 where symbol="IGFBP3";
UPDATE gene set taxon_id=6 where symbol="IKBKB";
UPDATE gene set taxon_id=3 where symbol="IL2";
UPDATE gene set taxon_id=6 where symbol="IL2RG";
UPDATE gene set taxon_id=1 where symbol="IL6";
UPDATE gene set taxon_id=3 where symbol="IL7";
UPDATE gene set taxon_id=1 where symbol="IL7R";
UPDATE gene set taxon_id=6 where symbol="INS";
UPDATE gene set taxon_id=6 where symbol="INSR";
UPDATE gene set taxon_id=6 where symbol="IRS1";
UPDATE gene set taxon_id=6 where symbol="IRS2";
UPDATE gene set taxon_id=6 where symbol="JAK2";
UPDATE gene set taxon_id=2 where symbol="JUN";
UPDATE gene set taxon_id=6 where symbol="JUND";
UPDATE gene set taxon_id=2 where symbol="KCNA3";
UPDATE gene set taxon_id=6 where symbol="KL";
UPDATE gene set taxon_id=8 where symbol="LEP";
UPDATE gene set taxon_id=6 where symbol="LEPR";
UPDATE gene set taxon_id=2 where symbol="LMNA";
UPDATE gene set taxon_id=2 where symbol="LMNB1";
UPDATE gene set taxon_id=2 where symbol="LRP2";
UPDATE gene set taxon_id=6 where symbol="MAP3K5";
UPDATE gene set taxon_id=5 where symbol="MAPK14";
UPDATE gene set taxon_id=5 where symbol="MAPK3";
UPDATE gene set taxon_id=2 where symbol="MAPK8";
UPDATE gene set taxon_id=6 where symbol="MAPK9";
UPDATE gene set taxon_id=8 where symbol="MAPT";
UPDATE gene set taxon_id=6 where symbol="MAX";
UPDATE gene set taxon_id=6 where symbol="MDM2";
UPDATE gene set taxon_id=8 where symbol="MED1";
UPDATE gene set taxon_id=6 where symbol="MIF";
UPDATE gene set taxon_id=5 where symbol="MLH1";
UPDATE gene set taxon_id=5 where symbol="MSRA";
UPDATE gene set taxon_id=5 where symbol="MT-CO1";
UPDATE gene set taxon_id=4 where symbol="MT1E";
UPDATE gene set taxon_id=5 where symbol="MTOR";
UPDATE gene set taxon_id=6 where symbol="MXD1";
UPDATE gene set taxon_id=6 where symbol="MXI1";
UPDATE gene set taxon_id=6 where symbol="MYC";
UPDATE gene set taxon_id=6 where symbol="NBN";
UPDATE gene set taxon_id=6 where symbol="NCOR1";
UPDATE gene set taxon_id=6 where symbol="NCOR2";
UPDATE gene set taxon_id=6 where symbol="NFE2L1";
UPDATE gene set taxon_id=6 where symbol="NFE2L2";
UPDATE gene set taxon_id=8 where symbol="NFKB1";
UPDATE gene set taxon_id=2 where symbol="NFKB2";
UPDATE gene set taxon_id=2 where symbol="NFKBIA";
UPDATE gene set taxon_id=8 where symbol="NGF";
UPDATE gene set taxon_id=6 where symbol="NGFR";
UPDATE gene set taxon_id=6 where symbol="NOG";
UPDATE gene set taxon_id=6 where symbol="NR3C1";
UPDATE gene set taxon_id=6 where symbol="NRG1";
UPDATE gene set taxon_id=6 where symbol="NUDT1";
UPDATE gene set taxon_id=6 where symbol="PAPPA";
UPDATE gene set taxon_id=5 where symbol="PARP1";
UPDATE gene set taxon_id=2 where symbol="PCK1";
UPDATE gene set taxon_id=5 where symbol="PCMT1";
UPDATE gene set taxon_id=5 where symbol="PCNA";
UPDATE gene set taxon_id=6 where symbol="PDGFB";
UPDATE gene set taxon_id=2 where symbol="PDGFRA";
UPDATE gene set taxon_id=6 where symbol="PDGFRB";
UPDATE gene set taxon_id=5 where symbol="PDPK1";
UPDATE gene set taxon_id=2 where symbol="PEX5";
UPDATE gene set taxon_id=2 where symbol="PIK3CA";
UPDATE gene set taxon_id=6 where symbol="PIK3CB";
UPDATE gene set taxon_id=2 where symbol="PIK3R1";
UPDATE gene set taxon_id=5 where symbol="PIN1";
UPDATE gene set taxon_id=6 where symbol="PLAU";
UPDATE gene set taxon_id=5 where symbol="PLCG2";
UPDATE gene set taxon_id=8 where symbol="PMCH";
UPDATE gene set taxon_id=1 where symbol="PML";
UPDATE gene set taxon_id=5 where symbol="POLA1";
UPDATE gene set taxon_id=6 where symbol="POLB";
UPDATE gene set taxon_id=5 where symbol="POLD1";
UPDATE gene set taxon_id=7 where symbol="POLG";
UPDATE gene set taxon_id=3 where symbol="PON1";
UPDATE gene set taxon_id=6 where symbol="POU1F1";
UPDATE gene set taxon_id=6 where symbol="PPARA";
UPDATE gene set taxon_id=6 where symbol="PPARG";
UPDATE gene set taxon_id=8 where symbol="PPARGC1A";
UPDATE gene set taxon_id=6 where symbol="PPM1D";
UPDATE gene set taxon_id=5 where symbol="PPP1CA";
UPDATE gene set taxon_id=6 where symbol="PRDX1";
UPDATE gene set taxon_id=2 where symbol="PRKCA";
UPDATE gene set taxon_id=2 where symbol="PRKCD";
UPDATE gene set taxon_id=2 where symbol="PRKDC";
UPDATE gene set taxon_id=3 where symbol="PROP1";
UPDATE gene set taxon_id=5 where symbol="PSEN1";
UPDATE gene set taxon_id=2 where symbol="PTEN";
UPDATE gene set taxon_id=6 where symbol="PTGS2";
UPDATE gene set taxon_id=2 where symbol="PTK2";
UPDATE gene set taxon_id=8 where symbol="PTK2B";
UPDATE gene set taxon_id=6 where symbol="PTPN1";
UPDATE gene set taxon_id=2 where symbol="PTPN11";
UPDATE gene set taxon_id=2 where symbol="PYCR1";
UPDATE gene set taxon_id=5 where symbol="RAD51";
UPDATE gene set taxon_id=6 where symbol="RAD52";
UPDATE gene set taxon_id=5 where symbol="RAE1";
UPDATE gene set taxon_id=6 where symbol="RB1";
UPDATE gene set taxon_id=6 where symbol="RECQL4";
UPDATE gene set taxon_id=6 where symbol="RELA";
UPDATE gene set taxon_id=6 where symbol="RET";
UPDATE gene set taxon_id=7 where symbol="RGN";
UPDATE gene set taxon_id=6 where symbol="RICTOR";
UPDATE gene set taxon_id=5 where symbol="RPA1";
UPDATE gene set taxon_id=6 where symbol="S100B";
UPDATE gene set taxon_id=2 where symbol="SDHC";
UPDATE gene set taxon_id=2 where symbol="SERPINE1";
UPDATE gene set taxon_id=6 where symbol="SHC1";
UPDATE gene set taxon_id=2 where symbol="SIN3A";
UPDATE gene set taxon_id=6 where symbol="SIRT1";
UPDATE gene set taxon_id=6 where symbol="SIRT3";
UPDATE gene set taxon_id=5 where symbol="SIRT6";
UPDATE gene set taxon_id=2 where symbol="SIRT7";
UPDATE gene set taxon_id=6 where symbol="SLC13A1";
UPDATE gene set taxon_id=6 where symbol="SNCG";
UPDATE gene set taxon_id=6 where symbol="SOCS2";
UPDATE gene set taxon_id=5 where symbol="SOD1";
UPDATE gene set taxon_id=5 where symbol="SOD2";
UPDATE gene set taxon_id=6 where symbol="SP1";
UPDATE gene set taxon_id=6 where symbol="SPRTN";
UPDATE gene set taxon_id=6 where symbol="SQSTM1";
UPDATE gene set taxon_id=6 where symbol="SST";
UPDATE gene set taxon_id=6 where symbol="SSTR3";
UPDATE gene set taxon_id=6 where symbol="STAT3";
UPDATE gene set taxon_id=2 where symbol="STAT5A";
UPDATE gene set taxon_id=2 where symbol="STAT5B";
UPDATE gene set taxon_id=2 where symbol="STK11";
UPDATE gene set taxon_id=5 where symbol="STUB1";
UPDATE gene set taxon_id=2 where symbol="SUMO1";
UPDATE gene set taxon_id=6 where symbol="SUN1";
UPDATE gene set taxon_id=2 where symbol="TAF1";
UPDATE gene set taxon_id=5 where symbol="TBP";
UPDATE gene set taxon_id=6 where symbol="TCF3";
UPDATE gene set taxon_id=6 where symbol="TERF1";
UPDATE gene set taxon_id=6 where symbol="TERF2";
UPDATE gene set taxon_id=6 where symbol="TERT";
UPDATE gene set taxon_id=2 where symbol="TFAP2A";
UPDATE gene set taxon_id=6 where symbol="TFDP1";
UPDATE gene set taxon_id=6 where symbol="TGFB1";
UPDATE gene set taxon_id=8 where symbol="TNF";
UPDATE gene set taxon_id=5 where symbol="TOP1";
UPDATE gene set taxon_id=2 where symbol="TOP2A";
UPDATE gene set taxon_id=5 where symbol="TOP2B";
UPDATE gene set taxon_id=5 where symbol="TOP3B";
UPDATE gene set taxon_id=6 where symbol="TP53";
UPDATE gene set taxon_id=8 where symbol="TP53BP1";
UPDATE gene set taxon_id=6 where symbol="TP63";
UPDATE gene set taxon_id=6 where symbol="TP73";
UPDATE gene set taxon_id=5 where symbol="TPP2";
UPDATE gene set taxon_id=2 where symbol="TRAP1";
UPDATE gene set taxon_id=6 where symbol="TRPV1";
UPDATE gene set taxon_id=5 where symbol="TXN";
UPDATE gene set taxon_id=5 where symbol="UBB";
UPDATE gene set taxon_id=5 where symbol="UBE2I";
UPDATE gene set taxon_id=6 where symbol="UCHL1";
UPDATE gene set taxon_id=3 where symbol="UCP1";
UPDATE gene set taxon_id=5 where symbol="UCP2";
UPDATE gene set taxon_id=5 where symbol="UCP3";
UPDATE gene set taxon_id=5 where symbol="VCP";
UPDATE gene set taxon_id=6 where symbol="VEGFA";
UPDATE gene set taxon_id=5 where symbol="WRN";
UPDATE gene set taxon_id=2 where symbol="XPA";
UPDATE gene set taxon_id=5 where symbol="XRCC5";
UPDATE gene set taxon_id=5 where symbol="XRCC6";
UPDATE gene set taxon_id=2 where symbol="YWHAZ";
UPDATE gene set taxon_id=5 where symbol="ZMPSTE24";
');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_taxon', 'gene');
        $this->dropColumn('gene', 'taxon_id');
        $this->dropTable('taxon');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200302_190414_early_taxon cannot be reverted.\n";

        return false;
    }
    */
}
