<?php

$PluginInfo['DiscussionMarker'] = array(
    'Name' => 'Discussion Marker',
    'Description' => 'Label a discussion on Discussions page based on words contained in Title.  Options for click scrolling or click searching for Labels',
    'Version' => '1.8',
    'SettingsUrl' => '/dashboard/settings/DiscussionMarker',
    'MobileFriendly' => true,
    'Author' => 'Peregrine',
    'License' => 'GNU GPL2'
);

class DiscussionMarkerPlugin extends Gdn_Plugin {

    public function settingsController_discussionMarker_create($sender) {
        $sender->title('Discussion Marker');
        $sender->addSideMenu('plugin/discussionmarker');
        $sender->permission('Garden.Settings.Manage');

        $sender->Form = new Gdn_Form();
        $validation = new Gdn_Validation();
        $configurationModel = new Gdn_ConfigurationModel($validation);
        $configurationModel->setField(array(
            'Plugins.DiscussionMarker.WordList',
            'Plugins.DiscussionMarker.AllowJump',
            'Plugins.DiscussionMarker.GroupLabels',
        ));
        $sender->Form->setModel($configurationModel);

        if ($sender->Form->authenticatedPostBack() && $sender->Form->save()) {
            $sender->informMessage(t('Your settings have been saved.'));
        } else {
            $sender->Form->setData($configurationModel->Data);
        }

        $sender->render($this->getView('discussionmarker-settings.php'));
    }

    public function discussionsController_beforeDiscussionMeta_handler($sender, $args) {
        $this->displayMarker($sender, $args);
    }

    public function categoriesController_beforeDiscussionMeta_handler($sender, $args) {
        $this->displayMarker($sender, $args);
    }


    public function discussionsController_render_before($sender) {
        $sender->addCssFile('dm.css', 'plugins/DiscussionMarker');
        if (c('Plugins.DiscussionMarker.AllowJump', false) == 'Scroll') {
            $sender->addJsFile($this->getResource('js/discussionmarker.js', false, false));
        }
    }

    public function categoriesController_render_before($sender) {
        $sender->addCssFile('dm.css', 'plugins/DiscussionMarker');
        if (c('Plugins.DiscussionMarker.AllowJump', false) == 'Scroll') {
            $sender->addJsFile($this->getResource('js/discussionmarker.js', false, false));
        }
    }

    protected function displayMarker($sender, $args) {
        $title = val('Name', $args['Discussion']);
        $markerArray = preg_split('/ *, */', c('Plugins.DiscussionMarker.WordList'));

        foreach ($markerArray as $marker) {
            if (!preg_match('/\b'.$marker.'\b/', $title)) {
                continue;
            }

            $tagmarker = preg_replace('/[\s]/', '-', $marker);
            if (c('Plugins.DiscussionMarker.GroupLabels', false)) {
                $lMarker = 'DLP ' .$marker;
                $marker = ucwords(strtolower(t($lMarker)));
            }
            $marker = ucwords(strtolower($marker));
            if (c('Plugins.DiscussionMarker.AllowJump', false) != 'Search') {
                echo wrap($marker, 'span', array('class' => 'Tag DMarker DMarker-'.$tagmarker));
            } else {
                $searchurl = 'search&Search=' . preg_replace('/[\s]/', '+', $marker);
                echo anchor(wrap(Gdn_Format::text($marker), 'span',
                    array('class' => 'Tag DMarker DMarker-'.$tagmarker )), $searchurl);
            }
        }
    }

}
