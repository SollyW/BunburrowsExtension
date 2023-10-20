<?php

namespace BunburrowsExtension;

use MediaWiki\Hook\BeforePageDisplayHook;
use Mediawiki\Revision\RevisionLookup;

class ClassCategories implements BeforePageDisplayHook {
    private $categoryClassMap;

    public function __construct( RevisionLookup $revisionLookup ) {
        $this->categoryClassMap = $this->createCategoryClassMap( $revisionLookup );
    }

    public function onBeforePageDisplay( $out, $skin ): void {
        foreach ( $out->getCategories() as $category ) {
            $class = $this->categoryClassMap[strtr( $category, ' ', '_' )];
            if ( $class ) {
                $out->addBodyClasses( $class );
            }
        }
    }

    private function createCategoryClassMap( $revisionLookup ) {
        preg_match_all( '/^\*\s+(?<category>\S+)\s*\|(?<classes>[\w\d\-_ ]+)$/m',
                        Util::getMediaWikiPage( 'Class categories', $revisionLookup ),
                        $entries,
                        PREG_SET_ORDER
                       );
        $output = [];
        foreach ( $entries as $entry ) {
            $output[$entry['category']] = $entry['classes'];
        }

        return $output;
    }
}
