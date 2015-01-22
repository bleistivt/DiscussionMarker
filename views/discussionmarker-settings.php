<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>

<h1><?php echo T('Discussion Marker / by Peregrine'); ?></h1>

<div class="Info"><?php echo T("Please see the readme if you have questions about plugin"); ?></div>

<table class="AltRows"'>
    <tbody>
        <?php
        echo("<tr><td>");
        echo T("Enter Your List of words in lower case letters separated by commas e.g.  'for sale, buy, wanted '");
        echo "</td><td>";
        echo $this->Form->TextBox('Plugins.DiscussionMarker.WordList');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo T("Allow clicking on Marker Label");
        echo "</td>";
        echo "<td>";
        $Fields = array('TextField' => 'Code', 'ValueField' => 'Code');
        $Options = array( "0" => 'Clicking Not Enabled', 'Scroll' => 'Scroll Within Page', 'Search' => 'Search Results Page');
        echo $this->Form->DropDown('Plugins.DiscussionMarker.AllowJump', $Options, $Fields);
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo T("Use Group Labeling with MANDATORY definitions (i.e. multiple words with same label name)");
        echo "</td>";
        echo "<td>";
        echo $this->Form->CheckBox('Plugins.DiscussionMarker.GroupLabels', "");
        echo "</td>";
        echo "</tr>";
        ?>
    </tbody>
</table>
<br />

<?php echo $this->Form->Close('Submit'); ?>
