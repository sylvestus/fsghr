<?php

/**
 * ModuleDefaultPageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ModuleDefaultPageTable extends PluginModuleDefaultPageTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object ModuleDefaultPageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ModuleDefaultPage');
    }
}