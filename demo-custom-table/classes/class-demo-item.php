<?php

namespace JansenMorin\DemoCustomTable;

class DemoItem {
    public $id;
    public $date_created;
    public $name;

    public function __construct ( $properties ) {
        if ( ! empty( $properties['id'] ) ) {
            $this->id = $properties['id'];
        }

        if ( ! empty( $properties['date_created'] ) ) {
            $this->date_created = $properties['date_created'];
        }

        if ( ! empty( $properties['name'] ) ) {
            $this->name = $properties['name'];
        }
    }
}