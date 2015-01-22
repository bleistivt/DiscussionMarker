<?php if (!defined('APPLICATION'))  exit();

$PluginInfo['DiscussionMarker'] = array(
    'Name' => 'Discussion Marker',
    'Description' => 'Label a discussion on Discussions page based on words contained in Title.  Options for click scrolling or click searching for Labels',
    'Version' => '1.7',
    'SettingsUrl' => '/dashboard/settings/DiscussionMarker',
    'MobileFriendly' => true,
    'Author' => "Peregrine"
);

class DiscussionMarkerPlugin extends Gdn_Plugin {

    public function SettingsController_DiscussionMarker_Create($Sender) {
        $Session = Gdn::Session();
        $Sender->Title('Discussion Marker');
        $Sender->AddSideMenu('plugin/discussionmarker');
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->Form = new Gdn_Form();
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.DiscussionMarker.WordList',
            'Plugins.DiscussionMarker.AllowJump',
            'Plugins.DiscussionMarker.GroupLabels',
        ));
        $Sender->Form->SetModel($ConfigurationModel);


        if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
            $Sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $Data = $Sender->Form->FormValues();

            if ($Sender->Form->Save() !== FALSE)
                $Sender->StatusMessage = T("Your settings have been saved.");
        }
        $Sender->Render($this->GetView('discussionmarker-settings.php'));
    }

    public function DiscussionsController_BeforeDiscussionMeta_Handler($Sender) {
        $this->DisplayMarker($Sender);
    }

    public function CategoriesController_BeforeDiscussionMeta_Handler($Sender) {
        $this->DisplayMarker($Sender);
    }


    public function DiscussionsController_Render_Before($Sender) {
        $Sender->AddCssFile('dm.css', 'plugins/DiscussionMarker');
        if (C('Plugins.DiscussionMarker.AllowJump', FALSE) == "Scroll") {
            $Sender->AddJsFile($this->GetResource('js/discussionmarker.js', FALSE, FALSE));
        }
    }

    public function CategoriesController_Render_Before($Sender) {
        $Sender->AddCssFile('dm.css', 'plugins/DiscussionMarker');
        if (C('Plugins.DiscussionMarker.AllowJump', FALSE) == "Scroll") {
            $Sender->AddJsFile($this->GetResource('js/discussionmarker.js', FALSE, FALSE));
        }
    }


    protected function DisplayMarker($Sender) {
        $Discussion = $Sender->EventArguments['Discussion'];
        $title = val('Name', $Discussion);

        // can also be used with discussion prefixes plugin.
        // $Prefixes = explode (";", C('Plugins.PrefixDiscussion.Prefixes'));
        $MarkerArray = explode(",", C('Plugins.DiscussionMarker.WordList'));

        foreach ($MarkerArray as $Marker) {
            $Marker = trim($Marker);

            $pos = stripos($title, $Marker);
            if (is_numeric($pos)) {
                $tagmarker = preg_replace("/[\s]/","-",$Marker);
                if (C('Plugins.DiscussionMarker.GroupLabels', FALSE)) {
                    $LMarker = "DLP " .$Marker;
                    $Marker =trim(ucwords(strtolower(T($LMarker))));
                }
                $Marker =trim(ucwords(strtolower($Marker)));
                if (C('Plugins.DiscussionMarker.AllowJump', FALSE) != "Search") {
                    echo Wrap($Marker, 'span', array('class' => "Tag DMarker DMarker-" . $tagmarker ));
                } else {
                    $searchurl = 'search&Search=' . preg_replace("/[\s]/","+",$Marker);
                    echo Anchor(Wrap(Gdn_Format::Text($Marker), 'span',
                        array('class' => "Tag DMarker DMarker-" . $tagmarker )),$searchurl);
                }
            }
        }
    }

}
