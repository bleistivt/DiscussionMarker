Thanks for using this Plugin.

you can change Label  colors per word or phrase etc via css

e.g.  if the phrase is "for sale"    then just use  .Dmarker-For-Sale
i.e - a dash between words and upper case the words in the css.


.DMarker.DMarker-For-Sale  {
     background-color: red;
}


-----------------------------------------------------------

If you enable clicking...


clicking refers discussion labels shown on the viewing page, it does not cycle beyond the viewing page.

If your forum is embedded - this clicking positioning  may not work as expected. or it may.  nevertheless nothing I can do about it


all phrases oe words should be entered in lower case  - the labels will convert words where each word will have the first letter capitalzed.


e.g.  Please enter your labels in the setting screen in lower case  "for sale, yard sale,  looking to rent, wanted"
      the 4 labels will become         For Sale  , Yard Sale  ,  Looking To Rent ,           and  Wanted 

---------------------------------------------------------------

WARNING:  if you check  Group Labeling with definitions (i.e. multiple words with same label name")

You MUST add labels to your /conf/locale.php  or create one if none exists.

each definition is the name you assigned in your list of words in the setting screen prefaced with the letters DLP


<?php if (!defined('APPLICATION')) exit();


$Definition['DLP For sale'] = "For sale";
$Definition['DLP Yard Sale'] = "Yard Sale";
$Definition['DLP Looking To Rent'] = "Rental";
$Definition['DLP wanted'] = "Wanted";



if you want the Yard Sale and For Sale to group into a particular Label  e.g.  Sale

you could group by doing this.


$Definition['DLP For sale'] = "sale";
$Definition['DLP Yard Sale'] = "Sale";
$Definition['DLP Looking To Rent'] = "Rental";
$Definition['DLP wanted'] = "Wanted";



Note: When using the Search option for labels -  the search WILL  be for the words in the LABEL 

meaning if you grouped things like this  For sale and Yard Sale would have a label bingo.  
and when you click to search you WILL search for the word bingo.



$Definition['DLP For sale'] = "bingo";
$Definition['DLP Yard Sale'] = "bingo";



If you don not understand definitions please read the documentation on-site and or the forum,









