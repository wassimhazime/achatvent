<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\File\File;

class ConfigExternal {

    private $file;

    function __construct($PathConfigJsone) {

        $this->file = new File($PathConfigJsone, File::JSON, []);
    }

    public function getConnect(string $name = "Connect_DataBase"): array {
        $config = $this->file->get($name);
        return $config[$config['BOOT']];
    }

    public function is_set_cache(): bool {
        return $this->getConnect()["cache"];
    }

    public function getNameDataBase(): string {
        return $this->getConnect()["dbname"];
    }

    ///////////////////////////////////////////////////////////////////////////

    public function getSCHEMA_SELECT_MANUAL($name = "SCHEMA_SELECT_MANUAL"): array {
        return $this->file->get($name);
    }

    public function getSCHEMA_SELECT_AUTO($name = "SCHEMA_SELECT_AUTO"): array {
        return $this->file->get($name);
    }

    public function getgenerateCACHE_SELECT($name = "CACHE_SELECT"): array {
        return $this->file->get($name);
    }

    public function setgenerateCACHE_SELECT($schmaTabls) {
        $this->file->set($schmaTabls, "CACHE_SELECT");
    }

    public function removeCACHE_SELECT() {
        $this->file->remove("CACHE_SELECT");
    }

}
