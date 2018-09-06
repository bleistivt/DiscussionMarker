<?php

class DiscussionMarkerPlugin extends Gdn_Plugin {

    public function settingsController_discussionMarker_create($sender) {
        $sender->permission('Garden.Settings.Manage');
        $sender->setHighlightRoute();

        $conf = new ConfigurationModule($sender);
        $conf->initialize([
            'Plugins.DiscussionMarker.WordList' => [
                'Control' => 'textbox',
                'LabelCode' => 'Word List',
                'Description' => 'Enter your list of words, separated by commas; e.g. "for sale, buy, wanted".'
            ],
            'Plugins.DiscussionMarker.AllowJump' => [
                'Control' => 'dropdown',
                'LabelCode' => 'Allow Clicking on Marker Labels',
                'Items' => [
                    '0' => 'Clicking Not Enabled',
                    'Scroll' => 'Scroll Within Page',
                    'Search' => 'Search Results Page'
                ]
            ],
            'Plugins.DiscussionMarker.GroupLabels' => [
                'Control' => 'checkbox',
                'LabelCode' => 'Use Group Labeling (see README.md)'
            ]
        ]);

        $sender->title('Discussion Marker');
        $conf->renderAll();
    }


    public function discussionsController_beforeDiscussionMeta_handler($sender, $args) {
        $this->displayMarker($sender, $args);
    }


    public function categoriesController_beforeDiscussionMeta_handler($sender, $args) {
        $this->displayMarker($sender, $args);
    }


    public function discussionsController_render_before($sender) {
        if (c('Plugins.DiscussionMarker.AllowJump') == 'Scroll') {
            $sender->addJsFile('discussionmarker.js', 'plugins/DiscussionMarker');
        }
    }


    public function categoriesController_render_before($sender) {
        $this->discussionsController_render_before($sender);
    }


    protected function displayMarker($sender, $args) {
        $title = val('Name', $args['Discussion']);
        $markerArray = preg_split('/ *, */', c('Plugins.DiscussionMarker.WordList'));
        $echo = '';

        foreach ($markerArray as $marker) {
            if (!preg_match('/\b'.preg_quote($marker, '/').'\b/i', $title)) {
                continue;
            }

            $tagmarker = preg_replace('/[\s]/', '-', $marker);
            if (c('Plugins.DiscussionMarker.GroupLabels')) {
                $lMarker = 'DLP ' .$marker;
                $marker = ucwords(strtolower(t($lMarker)));
            }
            $marker = ucwords(strtolower($marker));
            if (c('Plugins.DiscussionMarker.AllowJump') != 'Search') {
                $echo .= wrap($marker, 'span', ['class' => 'Tag MItem DMarker DMarker-'.$tagmarker]);
            } else {
                $searchurl = 'search?'.http_build_query(['Search' => $marker]);
                $echo .= anchor(wrap(
                    Gdn_Format::text($marker),
                    'span',
                    ['class' => 'Tag MItem DMarker DMarker-'.$tagmarker]
                ), $searchurl);
            }
        }

        if ($echo) {
            echo '<div class="markergroup">'.$echo.'</div>';
        }
    }

}
