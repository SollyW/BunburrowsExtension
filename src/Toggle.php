<?php

namespace BunburrowsExtension;

use MediaWiki\Hook\ParserFirstCallInitHook;
use Html;
use Sanitizer;

class Toggle implements ParserFirstCallInitHook {
    public function onParserFirstCallInit( $parser ) {
        $parser->setHook( 'toggle', function ( $text, $params, $parser, $frame ) {
            $tickbox = Html::rawElement( 'input', [
                'class' => 'custom-toggle-tickbox',
                'id' => Sanitizer::safeEncodeAttribute( $params['id'] ),
                'type' => 'checkbox',
            ] );

            $label = Html::rawElement( 'label', [
                'class' => 'custom-toggle-label',
                'for' => Sanitizer::safeEncodeAttribute( $params['id'] )
            ], $parser->recursiveTagParse( $text ) );

            return $tickbox . $label;
        } );
    }
}
