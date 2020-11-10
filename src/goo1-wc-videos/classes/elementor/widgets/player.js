var akvjs = {
    init: function(id, options) {
    console.log("Optionen", options);
    akvjs.options = options;
    akvjs.id = id;
    akvjs.ele = jQuery(id);
    akvjs.quality = 1080;
    akvjs.vjs = videojs(id, {"playbackRates": [0.25, 0.5, 1.0, 2.0], "poster": "https://placehold.it/1920x1080.jpg?text=Poster"}, function(){
        console.log(akvjs.ele.length);
        jQuery(akvjs.id+" .vjs-progress-control").before('<div class="vjs-min10sec-button vjs-menu-button vjs-control vjs-button"><button class="vjs-min10sec-button vjs-button" type="button" aria-disabled="false" title="10sec zurück" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">-10sec</span></button></div>');
    
    
        var has_front = false;
        var has_top  = false;
        var has_site = false;
        var has_feet = false;
        for(var i = 0; i < player_data.length; i++) {
            var row = player_data[i];
            if (row.angle == "front") has_front = true;
            if (row.angle == "top"  ) has_top   = true;
            if (row.angle == "side" ) has_site  = true;
            if (row.angle == "feet" ) has_feet  = true;
        }
    
        var num_angles = 0;
        if (has_front) num_angles++;
        if (has_top  ) num_angles++;
        if (has_site ) num_angles++;
        if (has_feet ) num_angles++;
    
    
        if (num_angles > 1) {
            jQuery(akvjs.id+" div.vjs-playback-rate.vjs-menu-button").before('<div class="vjs-cams-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button"><button class="vjs-cams-button vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Camera" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Camera</span></button><div class="vjs-menu"><ul class="vjs-menu-content" role="menu"><li class="vjs-menu-title">'+"Camera"+'</li></ul></div>');
            if (has_front) jQuery(akvjs.id+" div.vjs-cams-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setcam(1);"><span class="vjs-menu-item-text">'+"Front"+'</span><span class="vjs-control-text" aria-live="polite"></span></li>');
            if (has_top  ) jQuery(akvjs.id+" div.vjs-cams-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setcam(2);"><span class="vjs-menu-item-text">'+"Top"+'</span><span class="vjs-control-text" aria-live="polite"></span></li>');
            if (has_site) jQuery(akvjs.id+" div.vjs-cams-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setcam(3);"><span class="vjs-menu-item-text">'+"Site"+'</span><span class="vjs-control-text" aria-live="polite"></span></li>');
            if (has_feet) jQuery(akvjs.id+" div.vjs-cams-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setcam(4);"><span class="vjs-menu-item-text">'+"Feet"+'</span><span class="vjs-control-text" aria-live="polite"></span></li>');
            jQuery("div.vjs-cams-button").hover(function() {
                jQuery(this).addClass("vjs-hover");
            }, function() {
                jQuery(this).removeClass("vjs-hover");
            });
    
                /*jQuery("button.vjs-cams-button").click(function() {
                    var a = akvjs.cam_current+1;
                    if (a > 5) a = 1;
                    akvjs.setcam(a);
                });*/
        }
    
    
        var has_2160p = false;
        var has_1080p = false;
        var has_480p = false;
        var has_240p = false;
        for(var i = 0; i < player_data.length; i++) {
            var row = player_data[i];
            if (row.quality == "2160p") has_2160p = true;
            if (row.quality == "1080p") has_1080p = true;
            if (row.quality == "480p") has_480p = true;
            if (row.quality == "240p") has_240p = true;
        }
    
        var num_qualities = 0;
        if (has_2160p) num_qualities++;
        if (has_1080p) num_qualities++;
        if (has_480p) num_qualities++;
        if (has_240p) num_qualities++;
    
        if (num_qualities > 1) jQuery(akvjs.id+" div.vjs-audio-button").after('<div class="vjs-quality-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button"><div class="vjs-quality-value">HD</div><button class="vjs-quality-rate vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Playback Rate" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Playback Rate</span></button><div class="vjs-menu"><ul class="vjs-menu-content" role="menu"><li class="vjs-menu-title">Qualität</li></ul></div></div>');
        if (has_2160p) jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(2160);"><span class="vjs-menu-item-text">2160p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
        if (has_1080p) jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(1080);"><span class="vjs-menu-item-text">1080p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
        if (has_480p)  jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(480);"><span class="vjs-menu-item-text">480p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
        if (has_240p)  jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(240);"><span class="vjs-menu-item-text">240p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
        jQuery("div.vjs-quality-button").hover(function() {
            console.log("hover quality");
            jQuery(this).addClass("vjs-hover");
        }, function() {
            jQuery(this).removeClass("vjs-hover");
        });
        
        jQuery("button.vjs-min10sec-button").click(function() {
            akvjs.secback(10);
        });
    
        console.log("player loaded", akvjs.vjs.language(), akvjs.vjs);
    });
    },
    enable_hotkeys: function() {
    jQuery(document).on("keypress", function(event) {
        switch (event.charCode) {
            case 32: /*Spacebar*/
                var isPlaying = !akvjs.vjs.paused();
                if (isPlaying) akvjs.vjs.pause(); else akvjs.vjs.play();
                return false;
            case 106: /*j - minus 10sec*/
                akvjs.secback(10);
                return false;
            case 108: /*l - plus 10 sec*/
                akvjs.secforward(10);
                return false;
            case 117:
                akvjs.vjs.playbackRate(0.25);
                return false;
            case 105:
                akvjs.vjs.playbackRate(0.5);
                return false;
            case 111:
                akvjs.vjs.playbackRate(1);
                return false;
            case 109: /*m - mute*/
                var a = akvjs.vjs.muted();
                akvjs.vjs.muted(!a);
                return false;
            case 103: /*g - -1frame*/
                akvjs.vjs.pause();
                akvjs.secback(1/60);
                return false;
            case 104: /*h - +1frame */
                akvjs.vjs.pause();
                akvjs.secforward(1/60);
                return false;
        }
    //alert('Handler for .keypress() called. - ' + event.charCode);
    });
    },
    setquality: function(value) {
    console.log("switch to quality", value);
    akvjs.quality = value;
    switch (value) {
        case 1080:
            jQuery(akvjs.id+" div.vjs-quality-value").text('HD');
            break;
        case 480:
            jQuery(akvjs.id+" div.vjs-quality-value").text('SD');
            break;
        case 240:
            jQuery(akvjs.id+" div.vjs-quality-value").html('<i class="far fa-mobile-android-alt"></i>');
            break;
        case 120:
            jQuery(akvjs.id+" div.vjs-quality-value").html('<i class="fas fa-pager"></i>');
            break;
    }
    var pos = akvjs.vjs.currentTime();
    akvjs.loadsource();
    akvjs.vjs.play();
    akvjs.vjs.currentTime(pos);
    },
    secback: function (sec) {
    var pos = akvjs.vjs.currentTime();
    pos = Math.max(0, pos - sec);
    akvjs.vjs.currentTime(pos);
    },
    secforward: function (sec) {
    var pos = akvjs.vjs.currentTime();
    pos = Math.min(akvjs.vjs.duration(), pos +sec);
    akvjs.vjs.currentTime(pos);
    }
    }