<?php

declare(strict_types=1);

namespace App\Enum;

/** 
 * ISO 3166-2:FR (https://fr.wikipedia.org/wiki/ISO_3166-2:FR)
 * 
 * @author Alexandre Tomatis <alexandre.tomatis@gmail.com> 
 */
enum County: string
{
    case Fr01 = 'FR-01';
    case Fr02 = 'FR-02';
    case Fr03 = 'FR-03';
    case Fr04 = 'FR-04';
    case Fr05 = 'FR-05';
    case Fr06 = 'FR-06';
    case Fr07 = 'FR-07';
    case Fr08 = 'FR-08';
    case Fr09 = 'FR-09';
    case Fr10 = 'FR-10';
    case Fr11 = 'FR-11';
    case Fr12 = 'FR-12';
    case Fr13 = 'FR-13';
    case Fr14 = 'FR-14';
    case Fr15 = 'FR-15';
    case Fr16 = 'FR-16';
    case Fr17 = 'FR-17';
    case Fr18 = 'FR-18';
    case Fr19 = 'FR-19';
    case Fr2A = 'FR-2A';
    case Fr2B = 'FR-2B';
    case Fr21 = 'FR-21';
    case Fr22 = 'FR-22';
    case Fr23 = 'FR-23';
    case Fr24 = 'FR-24';
    case Fr25 = 'FR-25';
    case Fr26 = 'FR-26';
    case Fr27 = 'FR-27';
    case Fr28 = 'FR-28';
    case Fr29 = 'FR-29';
    case Fr30 = 'FR-30';
    case Fr31 = 'FR-31';
    case Fr32 = 'FR-32';
    case Fr33 = 'FR-33';
    case Fr34 = 'FR-34';
    case Fr35 = 'FR-35';
    case Fr36 = 'FR-36';
    case Fr37 = 'FR-37';
    case Fr38 = 'FR-38';
    case Fr39 = 'FR-39';
    case Fr40 = 'FR-40';
    case Fr41 = 'FR-41';
    case Fr42 = 'FR-42';
    case Fr43 = 'FR-43';
    case Fr44 = 'FR-44';
    case Fr45 = 'FR-45';
    case Fr46 = 'FR-46';
    case Fr47 = 'FR-47';
    case Fr48 = 'FR-48';
    case Fr49 = 'FR-49';
    case Fr50 = 'FR-50';
    case Fr51 = 'FR-51';
    case Fr52 = 'FR-52';
    case Fr53 = 'FR-53';
    case Fr54 = 'FR-54';
    case Fr55 = 'FR-55';
    case Fr56 = 'FR-56';
    case Fr57 = 'FR-57';
    case Fr58 = 'FR-58';
    case Fr59 = 'FR-59';
    case Fr60 = 'FR-60';
    case Fr61 = 'FR-61';
    case Fr62 = 'FR-62';
    case Fr63 = 'FR-63';
    case Fr64 = 'FR-64';
    case Fr65 = 'FR-65';
    case Fr66 = 'FR-66';
    case Fr67 = 'FR-67';
    case Fr68 = 'FR-68';
    case Fr69 = 'FR-69';
    case Fr70 = 'FR-70';
    case Fr71 = 'FR-71';
    case Fr72 = 'FR-72';
    case Fr73 = 'FR-73';
    case Fr74 = 'FR-74';
    case Fr75 = 'FR-75';
    case Fr76 = 'FR-76';
    case Fr77 = 'FR-77';
    case Fr78 = 'FR-78';
    case Fr79 = 'FR-79';
    case Fr80 = 'FR-80';
    case Fr81 = 'FR-81';
    case Fr82 = 'FR-82';
    case Fr83 = 'FR-83';
    case Fr84 = 'FR-84';
    case Fr85 = 'FR-85';
    case Fr86 = 'FR-86';
    case Fr87 = 'FR-87';
    case Fr88 = 'FR-88';
    case Fr89 = 'FR-89';
    case Fr90 = 'FR-90';
    case Fr91 = 'FR-91';
    case Fr92 = 'FR-92';
    case Fr93 = 'FR-93';
    case Fr94 = 'FR-94';
    case Fr95 = 'FR-95';
    case Fr974 = 'FR-974';

    private const map = [
        self::Fr01->value => 'Ain',
        self::Fr02->value => 'Aisne ',
        self::Fr03->value => 'Allier',
        self::Fr04->value => 'Alpes-de-Haute-Provence',
        self::Fr05->value => 'Hautes-Alpes',
        self::Fr06->value => 'Alpes-Maritimes',
        self::Fr07->value => 'Ardèche',
        self::Fr08->value => 'Ardennes',
        self::Fr09->value => 'Ariège',
        self::Fr10->value => 'Aube',
        self::Fr11->value => 'Aude',
        self::Fr12->value => 'Aveyron',
        self::Fr13->value => 'Bouches-du-Rhône',
        self::Fr14->value => 'Calvados',
        self::Fr15->value => 'Cantal',
        self::Fr16->value => 'Charente',
        self::Fr17->value => 'Charente-Maritime',
        self::Fr18->value => 'Cher',
        self::Fr19->value => 'Corrèze',
        self::Fr2A->value => 'Corse-du-Sud',
        self::Fr2B->value => 'Haute-Corse',
        self::Fr21->value => 'Côte-d’Or',
        self::Fr22->value => 'Côtes-d’Armor',
        self::Fr23->value => 'Creuse',
        self::Fr24->value => 'Dordogne',
        self::Fr25->value => 'Doubs',
        self::Fr26->value => 'Drôme',
        self::Fr27->value => 'Eure',
        self::Fr28->value => 'Eure-et-Loir',
        self::Fr29->value => 'Finistère',
        self::Fr30->value => 'Gard',
        self::Fr31->value => 'Haute-Garonne',
        self::Fr32->value => 'Gers',
        self::Fr33->value => 'Gironde',
        self::Fr34->value => 'Hérault',
        self::Fr35->value => 'Ille-et-Vilaine',
        self::Fr36->value => 'Indre',
        self::Fr37->value => 'Indre-et-Loire',
        self::Fr38->value => 'Isère',
        self::Fr39->value => 'Jura',
        self::Fr40->value => 'Landes',
        self::Fr41->value => 'Loir-et-Cher',
        self::Fr42->value => 'Loire',
        self::Fr43->value => 'Haute-Loire',
        self::Fr44->value => 'Loire-Atlantique',
        self::Fr45->value => 'Loiret',
        self::Fr46->value => 'Lot',
        self::Fr47->value => 'Lot-et-Garonne',
        self::Fr48->value => 'Lozère',
        self::Fr49->value => 'Maine-et-Loire',
        self::Fr50->value => 'Manche',
        self::Fr51->value => 'Marne',
        self::Fr52->value => 'Haute-Marne',
        self::Fr53->value => 'Mayenne',
        self::Fr54->value => 'Meurthe-et-Moselle',
        self::Fr55->value => 'Meuse',
        self::Fr56->value => 'Morbihan',
        self::Fr57->value => 'Moselle',
        self::Fr58->value => 'Nièvre',
        self::Fr59->value => 'Nord',
        self::Fr60->value => 'Oise',
        self::Fr61->value => 'Orne',
        self::Fr62->value => 'Pas-de-Calais',
        self::Fr63->value => 'Puy-de-Dôme',
        self::Fr64->value => 'Pyrénées-Atlantiques',
        self::Fr65->value => 'Hautes-Pyrénées ',
        self::Fr66->value => 'Pyrénées-Orientales',
        self::Fr67->value => 'Bas-Rhin',
        self::Fr68->value => 'Haut-Rhin',
        self::Fr69->value => 'Rhône',
        self::Fr70->value => 'Haute-Saône',
        self::Fr71->value => 'Saône-et-Loire',
        self::Fr72->value => 'Sarthe',
        self::Fr73->value => 'Savoie',
        self::Fr74->value => 'Haute-Savoie',
        self::Fr75->value => 'Arrondissement de Paris',
        self::Fr76->value => 'Seine-Maritime',
        self::Fr77->value => 'Seine-et-Marne',
        self::Fr78->value => 'Yvelines',
        self::Fr79->value => 'Deux-Sèvres',
        self::Fr80->value => 'Somme',
        self::Fr81->value => 'Tarn',
        self::Fr82->value => 'Tarn-et-Garonne',
        self::Fr83->value => 'Var',
        self::Fr84->value => 'Vaucluse',
        self::Fr85->value => 'Vendée',
        self::Fr86->value => 'Vienne',
        self::Fr87->value => 'Haute-Vienne',
        self::Fr88->value => 'Vosges',
        self::Fr89->value => 'Yonne',
        self::Fr90->value => 'Territoire de Belfort',
        self::Fr91->value => 'Essonne',
        self::Fr92->value => 'Hauts-de-Seine',
        self::Fr93->value => 'Seine-Saint-Denis',
        self::Fr94->value => 'Val-de-Marne',
        self::Fr95->value => 'Val-d’Oise',
        self::Fr974->value => 'La Réunion',
    ];

    // $countyCode ISO 3166-2:FR
    static function getName(string $countyCode): string
    {
        return self::map[$countyCode];
    }
}
