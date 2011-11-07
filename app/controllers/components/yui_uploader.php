<?php 
class YuiUploaderHelper extends AppHelper { 
/** 
 * name property 
 * 
 * @var string 'YUIUploader' 
 * @access public 
 */ 
    var $name = 'YuiUploader'; 
/** 
 * helpers property 
 * 
 * @var array 
 * @access public 
 */ 
    var $helpers = array('Html', 'Javascript', 'Session'); 

/** 
 * undocumented function 
 * 
 * @param string $settings  
 * @return void 
 * @author Andrew 
 */ 
    function _includeLibraries() { 
        if ($this->__settings['cdn'] == 'google') { 
                return '<!-- Individual YUI JS files -->  
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>  
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/element/element-beta-min.js"></script>  
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/uploader/uploader-experimental.js"></script> 
                        '; 
        } elseif ($this->__settings['cdn'] == 'yahoo') { 
                return '<!-- Combo-handled YUI JS files: -->  
                        <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.6.0/build/yahoo-dom-event/yahoo-dom-event.js&2.6.0/build/element/element-beta-min.js&2.6.0/build/uploader/uploader-experimental.js"></script>'; 
        } else { 
                return $javascript->link(array('yahoo-dom-event', 'element-beta-min', 'uploader-experimental')); 
         } 
    } 
     
/** 
 * undocumented function 
 * 
 * @param string $settings  
 * @return void 
 * @author Andrew 
 */ 
    function uploader($settings='') { 
        $this->__settings = array_merge(array( 
            'cdn' => 'google', // 'google', 'yahoo', or false for hosting locally (you will be responsible for copying the library files).
            'handlerName' => 'YuiUploaderEventHandler',     
            'selectButtonId'  => 'selectLink', 
            'overlay' => 'uploaderOverlay', 
        ), (array)$settings); 
         
        ob_start(); 
        echo $this->_includeLibraries(); 
        ?> 
         
        <!-- YUI Uploader --> 
        <script type="text/javascript"> 
            YAHOO.widget.Uploader.SWFURL = "<?php e($this->Html->url('/swf/uploader.swf')) ?>"; 
            var uploader = new YAHOO.widget.Uploader("<?php e($this->__settings['overlay']) ?>"); 

            YAHOO.util.Event.onDOMReady(function () {  
                var uiLayer = YAHOO.util.Dom.getRegion('<?php e($this->__settings['selectButtonId']) ?>'); 
                var overlay = YAHOO.util.Dom.get("<?php e($this->__settings['overlay']) ?>"); 
                YAHOO.util.Dom.setStyle(overlay, 'width', uiLayer.right-uiLayer.left + "px"); 
                YAHOO.util.Dom.setStyle(overlay, 'height', uiLayer.bottom-uiLayer.top + "px"); 
            }); 
         
            uploader.addListener('contentReady', <?php e($this->__settings['handlerName']) ?>.contentReady); 
            uploader.addListener('fileSelect', <?php e($this->__settings['handlerName']) ?>.fileSelect) 
            uploader.addListener('uploadStart', <?php e($this->__settings['handlerName']) ?>.uploadStart); 
            uploader.addListener('uploadProgress', <?php e($this->__settings['handlerName']) ?>.uploadProgress); 
            uploader.addListener('uploadCancel', <?php e($this->__settings['handlerName']) ?>.uploadCancel); 
            uploader.addListener('uploadComplete', <?php e($this->__settings['handlerName']) ?>.uploadComplete); 
            uploader.addListener('uploadCompleteData', <?php e($this->__settings['handlerName']) ?>.uploadResponse); 
            uploader.addListener('uploadError', <?php e($this->__settings['handlerName']) ?>.uploadError); 
            uploader.addListener('rollOver', <?php e($this->__settings['handlerName']) ?>.rollOver); 
            uploader.addListener('rollOut', <?php e($this->__settings['handlerName']) ?>.rollOut); 
            uploader.addListener('click', <?php e($this->__settings['handlerName']) ?>.click); 
        </script> 
<?php 
        $ret = ob_get_contents(); 
        ob_end_clean(); 
        return $ret; 
    } 
} 
?> 