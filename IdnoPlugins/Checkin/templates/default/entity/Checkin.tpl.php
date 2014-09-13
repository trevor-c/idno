<?php

    $object = $vars['object'];
    /*
     * @var \Idno\Common\Entity $object
     */

?>

<div class="">

    <h2 class="p-geo">
        <a href="<?= $object->getURL() ?>" class="p-name"><?= $object->getTitle() ?></a>
        <span class="h-geo">
            <data class="p-latitude" value="<?= $object->lat ?>"></data>
        <data class="p-longitude" value="<?= $object->long ?>"></data>
        </span>
    </h2>

    <div id="map_<?= $object->_id ?>" style="height: 250px"></div>
    <div class="p-map">
        <?php
            if (!empty($object->body)) {
                echo $this->autop($this->parseURLs($this->parseHashtags($object->body)));
            }

            if (!empty($object->tags)) {
                ?>

                <p class="tag-row"><i class="icon-tag"></i> <?= $this->parseHashtags($object->tags) ?></p>

            <?php } ?>
    </div>

</div>
<script>
    var map<?=$object->_id?> = L.map('map_<?=$object->_id?>', {touchZoom: false, scrollWheelZoom: false}).setView([<?=$object->lat?>, <?=$object->long?>], 16);
    /*
    var layer<?=$object->_id?> = new L.StamenTileLayer("toner-lite");
    map<?=$object->_id?>.addLayer(layer<?=$object->_id?>);
    */
    
    var defaultLayer = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(map<?=$object->_id?>);
    
    var baseLayers = {
    			'OpenStreetMap Default': defaultLayer,
    			'OpenStreetMap German Style': L.tileLayer.provider('OpenStreetMap.DE'),
    			'OpenStreetMap Black and White': L.tileLayer.provider('OpenStreetMap.BlackAndWhite'),
    			'OpenStreetMap H.O.T.': L.tileLayer.provider('OpenStreetMap.HOT'),
    			'Thunderforest OpenCycleMap': L.tileLayer.provider('Thunderforest.OpenCycleMap'),
    			'Thunderforest Transport': L.tileLayer.provider('Thunderforest.Transport'),
    			'Thunderforest Landscape': L.tileLayer.provider('Thunderforest.Landscape'),
    			'Hydda Full': L.tileLayer.provider('Hydda.Full'),
    			'MapQuest OSM': L.tileLayer.provider('MapQuestOpen.OSM'),
    			'MapQuest Aerial': L.tileLayer.provider('MapQuestOpen.Aerial'),
    			'MapBox Example': L.tileLayer.provider('MapBox.examples.map-zr0njcqy'),
    			'Stamen Toner': L.tileLayer.provider('Stamen.Toner'),
    			'Stamen Terrain': L.tileLayer.provider('Stamen.Terrain'),
    			'Stamen Watercolor': L.tileLayer.provider('Stamen.Watercolor'),
    			'Esri WorldStreetMap': L.tileLayer.provider('Esri.WorldStreetMap'),
    			'Esri DeLorme': L.tileLayer.provider('Esri.DeLorme'),
    			'Esri WorldTopoMap': L.tileLayer.provider('Esri.WorldTopoMap'),
    			'Esri WorldImagery': L.tileLayer.provider('Esri.WorldImagery'),
    			'Esri WorldTerrain': L.tileLayer.provider('Esri.WorldTerrain'),
    			'Esri WorldShadedRelief': L.tileLayer.provider('Esri.WorldShadedRelief'),
    			'Esri WorldPhysical': L.tileLayer.provider('Esri.WorldPhysical'),
    			'Esri OceanBasemap': L.tileLayer.provider('Esri.OceanBasemap'),
    			'Esri NatGeoWorldMap': L.tileLayer.provider('Esri.NatGeoWorldMap'),
    			'Esri WorldGrayCanvas': L.tileLayer.provider('Esri.WorldGrayCanvas'),
    			'Acetate': L.tileLayer.provider('Acetate')
    		};

	var overlayLayers = {
		'OpenSeaMap': L.tileLayer.provider('OpenSeaMap'),
		'OpenWeatherMap Clouds': L.tileLayer.provider('OpenWeatherMap.Clouds'),
		'OpenWeatherMap CloudsClassic': L.tileLayer.provider('OpenWeatherMap.CloudsClassic'),
		'OpenWeatherMap Precipitation': L.tileLayer.provider('OpenWeatherMap.Precipitation'),
		'OpenWeatherMap PrecipitationClassic': L.tileLayer.provider('OpenWeatherMap.PrecipitationClassic'),
		'OpenWeatherMap Rain': L.tileLayer.provider('OpenWeatherMap.Rain'),
		'OpenWeatherMap RainClassic': L.tileLayer.provider('OpenWeatherMap.RainClassic'),
		'OpenWeatherMap Pressure': L.tileLayer.provider('OpenWeatherMap.Pressure'),
		'OpenWeatherMap PressureContour': L.tileLayer.provider('OpenWeatherMap.PressureContour'),
		'OpenWeatherMap Wind': L.tileLayer.provider('OpenWeatherMap.Wind'),
		'OpenWeatherMap Temperature': L.tileLayer.provider('OpenWeatherMap.Temperature'),
		'OpenWeatherMap Snow': L.tileLayer.provider('OpenWeatherMap.Snow')
	};

	var layerControl = L.control.layers(baseLayers, overlayLayers).addTo(map<?=$object->_id?>);
    
    var marker<?=$object->_id?> = L.marker([<?=$object->lat?>, <?=$object->long?>]);
    marker<?=$object->_id?>.addTo(map<?=$object->_id?>);
    //map<?=$object->_id?>.zoomControl.disable();
    map<?=$object->_id?>.scrollWheelZoom.disable();
    map<?=$object->_id?>.touchZoom.disable();
    map<?=$object->_id?>.doubleClickZoom.disable();
</script>