<?php

namespace BunburrowsExtension;

use MediaWiki\Title\Title;
use MediaWiki\Revision\SlotRecord;
use TextContent;

class Util {
    public static function getFile( $name, $mimeType, $repoGroup ) {
        $title = Title::makeTitleSafe( NS_FILE, $name );
        if ( !$title || !$title->exists() ) return false;

        $file = $repoGroup->findFile( $title );
        if ( !$file || $file->getMimeType() !== $mimeType ) return false;

        $output = file_get_contents( $file->getLocalRefPath() );
        if ( !$output ) return false;

        return trim( $output );
    }

    public static function getMediaWikiPage( $name, $revisionLookup ) {
        $revision = $revisionLookup->getRevisionByTitle( Title::makeTitle( NS_MEDIAWIKI, $name ) );
        if ( !$revision ) return '';

        $content = $revision->getContent( SlotRecord::MAIN );
        if ( !$content || $content->isEmpty() || !$content instanceof TextContent ) return '';

        return preg_replace( '/<!--.*?-->/s', '', $content->getText() );
    }
}
