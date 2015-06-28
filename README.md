DiscussionMarker
---

Thanks for using this plugin.

You can change Label colors per word or phrase etc via CSS.
e.g.  if the phrase is "for sale", just use  `.Dmarker-For-Sale`.
Use your browsers web inspector to find the right class names.

```css
.DMarker.DMarker-For-Sale  {
     background-color: red;
}
```

All phrases or words should be entered in lower case - the labels will be capitalized.
If you enter `for sale, yard sale, looking to rent, wanted`, you will get the labels `For Sale`, `Yard Sale`, `Looking To Rent` and `Wanted`

**Important:**  If you enable grouped labels with definitions (i.e. multiple words with same label name) you must add labels to your /conf/locale.php  or create one if it doesn't exist.

Example:

```php
<?php

$Definition['DLP For sale'] = "For sale";
$Definition['DLP Yard Sale'] = "Yard Sale";
$Definition['DLP Looking To Rent'] = "Rental";
$Definition['DLP wanted'] = "Wanted";
```

If you want the `Yard Sale` and `For Sale` to group into a particular Label e.g. `Sale`, you could group them like this:

```php
$Definition['DLP For sale'] = "Sale";
$Definition['DLP Yard Sale'] = "Sale";
$Definition['DLP Looking To Rent'] = "Rental";
$Definition['DLP wanted'] = "Wanted";
```

Note: When using the search option for labels - it will search for the words on the **label**. In the following example, it would search for "bingo":

```php
$Definition['DLP For sale'] = "bingo";
$Definition['DLP Yard Sale'] = "bingo";
```

If you don't understand definitions please take a look at this tutorial: http://vanillaforums.org/discussion/26597
