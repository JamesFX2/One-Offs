<?php 

// Takes array of text and spits out ngrams. Originally had 50,000 


$excerpts = array(
'free wallpaper samples',
'wallpaper samples',
'paint colours',
'oriental wallpaper',
'japanese wallpaper',
'london wallpaper',
'radiator paint',
'how to paint a radiator',
'eau de nil',
'english heritage paint',
'painting radiators',
'metallic wallpaper',
'distemper paint'
'washable acrylic paint for wall',
'washable bath room paint',
'washable black emulsion',
'washable blue paint',
'washable color chart for inside painting',
'washable colour emulsion paint',
'washable concrete floor paint',
'washable cream emulsion',
'washable cupboard paint',
'washable dance floor paint',
'washable dark grey paint',
'washable dispersion paint',
'washable eggshell',
'washable emulation paint',
'washable emulsion on doors',
'washable emulsion paint homebase',
'washable emultion',
'washable exterior eggshell',
'washable exterior paints',
'washable floor paint',
'washable gold matte wallpaper',
'washable grey paing',
'washable hard wearing white paint',
'washable hardwearing paint',
'washable hardwearing paint for kitchens',
'washable hot pink emulsion paint',
'washable house paint',
'washable kitchen cupboard paint',
'washable kitchen wallpaper',
'washable masonary paint',
'washable mat paint',
'washable matt emulsion for kitchens',
'washable matt mushroom paint',
'washable matt paint for kitchens uk',
'washable matt paint tips',
'washable matt white',
'washable paint colours',
'washable paint finish',
'washable paint for children',
'washable paint in bone china',
'washable paint in lilac',
'washable paint orange',
'washable paints for homes',
'washable paints for walls',
'washable pale pink paint',
'washable poppy wallpaper',
'washable red paint',
'washable victorian pink wallpapers',
'washable wall paint',
'washable white matt emulsion',
'washable white matt emulsion + southampton',
'washable wood colour uk',
'washable+emulsion+',
'washed linen paint colour',
'washed painters linen',
'washing oil based eggshell',
'wat is eau de nil',
'water acrylic eggshell enamel paint',
'water baae gloss paint',
'water base radiator paint',
'water based acrylic eggshell white paint woodwork',
'water based acrylic emulsion paint',
'water based acrylic gloss exterior paint',
'water based acrylic paint egg shell matt',
'water based acrylic paint shop london',
'water based acrylic paint to paint bathrom',
'water based alternative to gloss',
'water based black eggshell paint',
'water based cream eggshell paint',
'water based distemper',
'water based eggshell and radiators',
'water based eggshell finish',
'water based eggshell paint and radiator',
'water based eggshell paint for furnituret',
'water based egshell paint',
'water based exterior stone paint',
'water based floor paints for wood',
'water based gloss acrylic paint',
'water based gloss paint clours',
'water based gloss paint on radiators',
'water based gloss paint purple',
'water based gloss purple',
'water based lime',
'water based matt acrylic white paint',
'water based matt emulsion',
'water based matt emulsion information',
'water based matt emulsion paint',
'water based oils sky bkue',
'water based or synthetic paint for radiator',
'water based paint 1820',
'water based paint european standard code',
'water based paint formulation',
'water based paint in french',
'water based paint ok for radiators',
'water based paint on exterior plaster',
'water based paint voc',
'water based paint washable',
'water based paints for lime plaster',
'water based pearlescent paint formulation',
'water based red eggshell',
'water based satin paint',
'water based tester pots of paint gloss',
'water based vs acrylic gloss',
'water based wall paint',
'water based washable paint',
'water based white eggshell',
'water based white gloss',
'water bassed egg shell paint',
'water pipe acrylic eggshell paint',
'water resistant paint for attics uk',
'water-based acrylic emulsion paints',
'water-based acrylic paint',
'water-based distemper',
'water-based eggshell',
'water-based limewash paint',
'water-based paint sustainable',
'waterbased acrylic eggshell undercoat',
'waterbased acrylic eggshell varnish',
'waterbased acrylic-alkyd eggshell',
'waterbased gloss acrylic paint',
'waterbased gloss paints',
'waterbased outside wood paint mushroom colour',
'waterbased paint on heaters',
'waterbased paint on radiator?',
'waterbased paints',
'waterbasedpaint for radiators',
'waterborne paint for radiators',
'waterproof eggshell floor paint',
'waterproof exterior door eggshell paint',
'waterproof paint french grey',
'waterproofing eggshell paint'
);

mb_internal_encoding('UTF-8');

$joinedExcerpts = implode(".\n", $excerpts);
$sentences = preg_split('/[^\s|\pL]/umi', $joinedExcerpts, -1, PREG_SPLIT_NO_EMPTY);

$wordsSequencesCount = array();
foreach($sentences as $sentence) {
    $words = array_map('mb_strtolower',
                       preg_split('/[^\pL+]/umi', $sentence, -1, PREG_SPLIT_NO_EMPTY));
    foreach($words as $index => $word) {
        $wordsSequence = '';
        foreach(array_slice($words, $index) as $nextWord) {
                $wordsSequence .= $wordsSequence ? (' ' . $nextWord) : $nextWord;
            if( !isset($wordsSequencesCount[$wordsSequence]) ) {
                $wordsSequencesCount[$wordsSequence] = 0;
            }
            ++$wordsSequencesCount[$wordsSequence];
        }
    }
}

$ngramsCount = array_filter($wordsSequencesCount,
                            function($count) { return $count > 1; });
	//print_r($wordsSequencesCount);
	$count = 0;
	foreach($ngramsCount as $key => $value)
	{
		if(str_word_count($key)>2)
		{
			$store[$count]['value'] = $key;
			$store[$count]['count'] = $value;
			$count++;
		}
		
	}
//	print_r($store);

$file = fopen("ngrams.csv","w");

foreach ($store as $line)
  {
  fputcsv($file,$line,",");
  }

fclose($file); 


?>
