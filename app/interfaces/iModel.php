<?php

interface iModel {
    public static function find($id);
    public static function all();
    public function save();
    public function delete();
}
