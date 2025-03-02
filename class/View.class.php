<?php
require_once(dirname(__FILE__) . '/ServerError.class.php');
class View {
    private $viewName, $pageTitle, $viewVars, $tplName, $customJS, $customCSS;

    /**
     * View constructor. Note that $viewName should match with views/$viewName.php
     * @param string $viewName: Name of the view
     * @param string $pageTitle: Page Title
     * @param string $tplName: Template name
     */
    function __construct($viewName, $pageTitle="", $tplName="default") {
        $this->viewName=$viewName;
        $this->pageTitle=$pageTitle;
        $this->viewVars=array();
        $this->customJS=array();
        $this->customCSS=array();
        $this->tplName=$tplName;

        if(!is_file(dirname(__FILE__) . '/../views/' . $this->viewName . '.view.php')) {
            ServerError::throwError(500, 'Unable to load view: ' . $viewName);
        }

        if(!is_file(dirname(__FILE__) . '/../views/template/' . $this->tplName . '.tpl.php')) {
            ServerError::throwError(500, 'Unable to load template: ' . $tplName);
        }
    }

    /**
     * Render View to clients. Pass $vars as variables key pair to let them to be used in the view file
     * @param array $vars: var key and value pairs
     */
    function render($vars = array()) {
        $currentView = $this;
        $pageTitle=$this->pageTitle;
        $customJS = $this->customJS;
        $customCSS = $this->customCSS;
        extract(array_merge($this->viewVars, $vars));
        include(dirname(__FILE__) . '/../views/template/' . $this->tplName . '.tpl.php');
    }

    /**
     * Add a single variable to the view
     * @param string $varName var name
     * @param $varValue: Var value
     */
    function addVar($varName, $varValue) {
        $this->viewVars[(string)$varName]=$varValue;
    }

    /**
     * @param string $js: Custom js file, note that ".js" and "js/" is not needed, only include the file name.
     */
    function addCustomJS($js) {
        array_push($this->customJS, $js);
    }

    /**
     * @param string $css: Custom css file, note that ".css" and "css/" is not needed, only include the file name.
     */
    function addCustomCSS($css) {
        array_push($this->customCSS, $css);
    }

    /** Show the main content, to be called in template only
     * @param array $vars: Variables to be used in the view, in form of key and value pairs
     */
    function showMainContent($vars=array()) {
        extract($vars);
        include(dirname(__FILE__) . '/../views/' . $this->viewName . '.view.php');
    }

    /** Include the UI Element (CSS/JS), to be called in template only (static function)
     * @param string $type: css or js
     * @param string $filenameWithoutExt: File name to include, do not trail with extensions
     * @param string $deferredJS: Defer JS load
     */
    static function IncludeUIElements($type, $filenameWithoutExt, $deferredJS=FALSE) {
        $path = $type . '/' . $filenameWithoutExt . '.' . $type;
        if(is_file($path)) {
            if($type === "css") {
                echo '<link rel="stylesheet" href="/' . $path . '">';
            }else if($type === "js") {
                echo '<script src="/' . $path . '"' . ($deferredJS == TRUE ? ' defer' : '') . '></script>';
            }else{
                echo '';
            }
        }
    }

    /**
     * Get current view name
     * @return string of current view name
     */
    function getViewName() {
        return $this->viewName;
    }
}
?>