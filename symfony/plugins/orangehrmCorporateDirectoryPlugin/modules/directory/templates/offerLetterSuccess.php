<?php
/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
?>

<?php

use_javascript(plugin_web_path('orangehrmCorporateDirectoryPlugin', 'js/viewDirectorySuccess'));
?>

    <div class="head">       
        <h1><?php echo __("Offer Letter ") ?></h1>
    </div>
    <div class="inner">
     <?php       include_once (str_replace("/var/www/html", "http://localhost",sfConfig::get("sf_web_dir").'/phpword/samples/docappointmentletter.php'));?>
    </div>
      