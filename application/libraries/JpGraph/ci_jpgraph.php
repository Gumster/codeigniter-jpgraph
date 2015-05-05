<?php

/**
 *  This is the jpgraph.php main file, minus the Graph() class
 *  That is now a CI class, and includes this file
 */


// Version info
define('JPG_VERSION','3.5.0b1');

// Minimum required PHP version
define('MIN_PHPVERSION','5.1.0');

// Special file name to indicate that we only want to calc
// the image map in the call to Graph::Stroke() used
// internally from the GetHTMLCSIM() method.
define('_CSIM_SPECIALFILE','_csim_special_');

// HTTP GET argument that is used with image map
// to indicate to the script to just generate the image
// and not the full CSIM HTML page.
define('_CSIM_DISPLAY','_jpg_csimd');

// Special filename for Graph::Stroke(). If this filename is given
// then the image will NOT be streamed to browser of file. Instead the
// Stroke call will return the handler for the created GD image.
define('_IMG_HANDLER','__handle');

// Special filename for Graph::Stroke(). If this filename is given
// the image will be stroked to a file with a name based on the script name.
define('_IMG_AUTO','auto');

// Tick density
define("TICKD_DENSE",1);
define("TICKD_NORMAL",2);
define("TICKD_SPARSE",3);
define("TICKD_VERYSPARSE",4);

// Side for ticks and labels.
define("SIDE_LEFT",-1);
define("SIDE_RIGHT",1);
define("SIDE_DOWN",-1);
define("SIDE_BOTTOM",-1);
define("SIDE_UP",1);
define("SIDE_TOP",1);

// Legend type stacked vertical or horizontal
define("LEGEND_VERT",0);
define("LEGEND_HOR",1);

// Mark types for plot marks
define("MARK_SQUARE",1);
define("MARK_UTRIANGLE",2);
define("MARK_DTRIANGLE",3);
define("MARK_DIAMOND",4);
define("MARK_CIRCLE",5);
define("MARK_FILLEDCIRCLE",6);
define("MARK_CROSS",7);
define("MARK_STAR",8);
define("MARK_X",9);
define("MARK_LEFTTRIANGLE",10);
define("MARK_RIGHTTRIANGLE",11);
define("MARK_FLASH",12);
define("MARK_IMG",13);
define("MARK_FLAG1",14);
define("MARK_FLAG2",15);
define("MARK_FLAG3",16);
define("MARK_FLAG4",17);

// Builtin images
define("MARK_IMG_PUSHPIN",50);
define("MARK_IMG_SPUSHPIN",50);
define("MARK_IMG_LPUSHPIN",51);
define("MARK_IMG_DIAMOND",52);
define("MARK_IMG_SQUARE",53);
define("MARK_IMG_STAR",54);
define("MARK_IMG_BALL",55);
define("MARK_IMG_SBALL",55);
define("MARK_IMG_MBALL",56);
define("MARK_IMG_LBALL",57);
define("MARK_IMG_BEVEL",58);

// Inline defines
define("INLINE_YES",1);
define("INLINE_NO",0);

// Format for background images
define("BGIMG_FILLPLOT",1);
define("BGIMG_FILLFRAME",2);
define("BGIMG_COPY",3);
define("BGIMG_CENTER",4);
define("BGIMG_FREE",5);

// Depth of objects
define("DEPTH_BACK",0);
define("DEPTH_FRONT",1);

// Direction
define("VERTICAL",1);
define("HORIZONTAL",0);

// Axis styles for scientific style axis
define('AXSTYLE_SIMPLE',1);
define('AXSTYLE_BOXIN',2);
define('AXSTYLE_BOXOUT',3);
define('AXSTYLE_YBOXIN',4);
define('AXSTYLE_YBOXOUT',5);

// Style for title backgrounds
define('TITLEBKG_STYLE1',1);
define('TITLEBKG_STYLE2',2);
define('TITLEBKG_STYLE3',3);
define('TITLEBKG_FRAME_NONE',0);
define('TITLEBKG_FRAME_FULL',1);
define('TITLEBKG_FRAME_BOTTOM',2);
define('TITLEBKG_FRAME_BEVEL',3);
define('TITLEBKG_FILLSTYLE_HSTRIPED',1);
define('TITLEBKG_FILLSTYLE_VSTRIPED',2);
define('TITLEBKG_FILLSTYLE_SOLID',3);

// Styles for axis labels background
define('LABELBKG_NONE',0);
define('LABELBKG_XAXIS',1);
define('LABELBKG_YAXIS',2);
define('LABELBKG_XAXISFULL',3);
define('LABELBKG_YAXISFULL',4);
define('LABELBKG_XYFULL',5);
define('LABELBKG_XY',6);


// Style for background gradient fills
define('BGRAD_FRAME',1);
define('BGRAD_MARGIN',2);
define('BGRAD_PLOT',3);

// Width of tab titles
define('TABTITLE_WIDTHFIT',0);
define('TABTITLE_WIDTHFULL',-1);

// Defines for 3D skew directions
define('SKEW3D_UP',0);
define('SKEW3D_DOWN',1);
define('SKEW3D_LEFT',2);
define('SKEW3D_RIGHT',3);

// For internal use only
define("_JPG_DEBUG",false);
define("_FORCE_IMGTOFILE",false);
define("_FORCE_IMGDIR",'/tmp/jpgimg/');


//
// Automatic settings of path for cache and font directory
// if they have not been previously specified
//
if(USE_CACHE) {
    if (!defined('CACHE_DIR')) {
        if ( strstr( PHP_OS, 'WIN') ) {
            if( empty($_SERVER['TEMP']) ) {
                $t = new ErrMsgText();
                $msg = $t->Get(11,$file,$lineno);
                die($msg);
            }
            else {
                define('CACHE_DIR', $_SERVER['TEMP'] . '/');
            }
        } else {
            define('CACHE_DIR','/tmp/jpgraph_cache/');
        }
    }
}
elseif( !defined('CACHE_DIR') ) {
    define('CACHE_DIR', '');
}

//
// Setup path for western/latin TTF fonts
//
if (!defined('TTF_DIR')) {
    if (strstr( PHP_OS, 'WIN') ) {
        $sroot = getenv('SystemRoot');
        if( empty($sroot) ) {
            $t = new ErrMsgText();
            $msg = $t->Get(12,$file,$lineno);
            die($msg);
        }
        else {
            define('TTF_DIR', $sroot.'/fonts/');
        }
    } else {
        define('TTF_DIR','/usr/share/fonts/truetype/');
    }
}

//
// Setup path for MultiByte TTF fonts (japanese, chinese etc.)
//
if (!defined('MBTTF_DIR')) {
    if (strstr( PHP_OS, 'WIN') ) {
        $sroot = getenv('SystemRoot');
        if( empty($sroot) ) {
            $t = new ErrMsgText();
            $msg = $t->Get(12,$file,$lineno);
            die($msg);
        }
        else {
            define('MBTTF_DIR', $sroot.'/fonts/');
        }
    } else {
        define('MBTTF_DIR','/usr/share/fonts/truetype/');
    }
}

//
// Check minimum PHP version
//
function CheckPHPVersion($aMinVersion) {
    list($majorC, $minorC, $editC) = preg_split('/[\/.-]/', PHP_VERSION);
    list($majorR, $minorR, $editR) = preg_split('/[\/.-]/', $aMinVersion);

    if ($majorC != $majorR) return false;
    if ($majorC < $majorR) return false;
    // same major - check minor
    if ($minorC > $minorR) return true;
    if ($minorC < $minorR) return false;
    // and same minor
    if ($editC  >= $editR)  return true;
    return true;
}

//
// Make sure PHP version is high enough
//
if( !CheckPHPVersion(MIN_PHPVERSION) ) {
    JpGraphError::RaiseL(13,PHP_VERSION,MIN_PHPVERSION);
    die();
}

//
// Make GD sanity check
//
if( !function_exists("imagetypes") || !function_exists('imagecreatefromstring') ) {
    JpGraphError::RaiseL(25001);
    //("This PHP installation is not configured with the GD library. Please recompile PHP with GD support to run JpGraph. (Neither function imagetypes() nor imagecreatefromstring() does exist)");
}

//
// Setup PHP error handler
//
function _phpErrorHandler($errno,$errmsg,$filename, $linenum, $vars) {
    // Respect current error level
    if( $errno & error_reporting() ) {
        JpGraphError::RaiseL(25003,basename($filename),$linenum,$errmsg);
    }
}

if( INSTALL_PHP_ERR_HANDLER ) {
    set_error_handler("_phpErrorHandler");
}

//
// Check if there were any warnings, perhaps some wrong includes by the user. In this
// case we raise it immediately since otherwise the image will not show and makes
// debugging difficult. This is controlled by the user setting CATCH_PHPERRMSG
//
if( isset($GLOBALS['php_errormsg']) && CATCH_PHPERRMSG && !preg_match('/|Deprecated|/i', $GLOBALS['php_errormsg']) ) {
    JpGraphError::RaiseL(25004,$GLOBALS['php_errormsg']);
}

// Useful mathematical function
function sign($a) {return $a >= 0 ? 1 : -1;}

//
// Utility function to generate an image name based on the filename we
// are running from and assuming we use auto detection of graphic format
// (top level), i.e it is safe to call this function
// from a script that uses JpGraph
//
function GenImgName() {
    // Determine what format we should use when we save the images
    $supported = imagetypes();
    if( $supported & IMG_PNG )    $img_format="png";
    elseif( $supported & IMG_GIF ) $img_format="gif";
    elseif( $supported & IMG_JPG ) $img_format="jpeg";
    elseif( $supported & IMG_WBMP ) $img_format="wbmp";
    elseif( $supported & IMG_XPM ) $img_format="xpm";


    if( !isset($_SERVER['PHP_SELF']) ) {
        JpGraphError::RaiseL(25005);
        //(" Can't access PHP_SELF, PHP global variable. You can't run PHP from command line if you want to use the 'auto' naming of cache or image files.");
    }
    $fname = basename($_SERVER['PHP_SELF']);
    if( !empty($_SERVER['QUERY_STRING']) ) {
        $q = @$_SERVER['QUERY_STRING'];
        $fname .= '_'.preg_replace("/\W/", "_", $q).'.'.$img_format;
    }
    else {
        $fname = substr($fname,0,strlen($fname)-4).'.'.$img_format;
    }
    return $fname;
}

//===================================================
// CLASS JpgTimer
// Description: General timing utility class to handle
// time measurement of generating graphs. Multiple
// timers can be started.
//===================================================
class JpgTimer {
    private $start, $idx;

    function __construct() {
        $this->idx=0;
    }

    // Push a new timer start on stack
    function Push() {
        list($ms,$s)=explode(" ",microtime());
        $this->start[$this->idx++]=floor($ms*1000) + 1000*$s;
    }

    // Pop the latest timer start and return the diff with the
    // current time
    function Pop() {
        assert($this->idx>0);
        list($ms,$s)=explode(" ",microtime());
        $etime=floor($ms*1000) + (1000*$s);
        $this->idx--;
        return $etime-$this->start[$this->idx];
    }
} // Class

//===================================================
// CLASS DateLocale
// Description: Hold localized text used in dates
//===================================================
class DateLocale {

    public $iLocale = 'C'; // environmental locale be used by default
    private $iDayAbb = null, $iShortDay = null, $iShortMonth = null, $iMonthName = null;

    function __construct() {
        settype($this->iDayAbb, 'array');
        settype($this->iShortDay, 'array');
        settype($this->iShortMonth, 'array');
        settype($this->iMonthName, 'array');
        $this->Set('C');
    }

    function Set($aLocale) {
        if ( in_array($aLocale, array_keys($this->iDayAbb)) ){
            $this->iLocale = $aLocale;
            return TRUE;  // already cached nothing else to do!
        }

        $pLocale = setlocale(LC_TIME, 0); // get current locale for LC_TIME

        if (is_array($aLocale)) {
            foreach ($aLocale as $loc) {
                $res = @setlocale(LC_TIME, $loc);
                if ( $res ) {
                    $aLocale = $loc;
                    break;
                }
            }
        }
        else {
            $res = @setlocale(LC_TIME, $aLocale);
        }

        if ( ! $res ) {
            JpGraphError::RaiseL(25007,$aLocale);
            //("You are trying to use the locale ($aLocale) which your PHP installation does not support. Hint: Use '' to indicate the default locale for this geographic region.");
            return FALSE;
        }

        $this->iLocale = $aLocale;
        for( $i = 0, $ofs = 0 - strftime('%w'); $i < 7; $i++, $ofs++ ) {
            $day = strftime('%a', strtotime("$ofs day"));
            $day[0] = strtoupper($day[0]);
            $this->iDayAbb[$aLocale][]= $day[0];
            $this->iShortDay[$aLocale][]= $day;
        }

        for($i=1; $i<=12; ++$i) {
            list($short ,$full) = explode('|', strftime("%b|%B",strtotime("2001-$i-01")));
            $this->iShortMonth[$aLocale][] = ucfirst($short);
            $this->iMonthName [$aLocale][] = ucfirst($full);
        }

        setlocale(LC_TIME, $pLocale);

        return TRUE;
    }


    function GetDayAbb() {
        return $this->iDayAbb[$this->iLocale];
    }

    function GetShortDay() {
        return $this->iShortDay[$this->iLocale];
    }

    function GetShortMonth() {
        return $this->iShortMonth[$this->iLocale];
    }

    function GetShortMonthName($aNbr) {
        return $this->iShortMonth[$this->iLocale][$aNbr];
    }

    function GetLongMonthName($aNbr) {
        return $this->iMonthName[$this->iLocale][$aNbr];
    }

    function GetMonth() {
        return $this->iMonthName[$this->iLocale];
    }
}

// Global object handlers
$gDateLocale = new DateLocale();
$gJpgDateLocale = new DateLocale();

//=======================================================
// CLASS Footer
// Description: Encapsulates the footer line in the Graph
//=======================================================
class Footer {
    public $iLeftMargin = 3, $iRightMargin = 3, $iBottomMargin = 3 ;
    public $left,$center,$right;
    private $iTimer=null, $itimerpoststring='';

    function __construct() {
        $this->left = new Text();
        $this->left->ParagraphAlign('left');
        $this->center = new Text();
        $this->center->ParagraphAlign('center');
        $this->right = new Text();
        $this->right->ParagraphAlign('right');
    }

    function SetTimer($aTimer,$aTimerPostString='') {
        $this->iTimer = $aTimer;
        $this->itimerpoststring = $aTimerPostString;
    }

    function SetMargin($aLeft=3,$aRight=3,$aBottom=3) {
        $this->iLeftMargin = $aLeft;
        $this->iRightMargin = $aRight;
        $this->iBottomMargin = $aBottom;
    }

    function Stroke($aImg) {
        $y = $aImg->height - $this->iBottomMargin;
        $x = $this->iLeftMargin;
        $this->left->Align('left','bottom');
        $this->left->Stroke($aImg,$x,$y);

        $x = ($aImg->width - $this->iLeftMargin - $this->iRightMargin)/2;
        $this->center->Align('center','bottom');
        $this->center->Stroke($aImg,$x,$y);

        $x = $aImg->width - $this->iRightMargin;
        $this->right->Align('right','bottom');
        if( $this->iTimer != null ) {
            $this->right->Set( $this->right->t . sprintf('%.3f',$this->iTimer->Pop()/1000.0) . $this->itimerpoststring );
        }
        $this->right->Stroke($aImg,$x,$y);
    }
}


//===================================================
// CLASS LineProperty
// Description: Holds properties for a line
//===================================================
class LineProperty {
    public $iWeight=1, $iColor='black', $iStyle='solid', $iShow=false;

    function __construct($aWeight=1,$aColor='black',$aStyle='solid') {
        $this->iWeight = $aWeight;
        $this->iColor = $aColor;
        $this->iStyle = $aStyle;
    }

    function SetColor($aColor) {
        $this->iColor = $aColor;
    }

    function SetWeight($aWeight) {
        $this->iWeight = $aWeight;
    }

    function SetStyle($aStyle) {
        $this->iStyle = $aStyle;
    }

    function Show($aShow=true) {
        $this->iShow=$aShow;
    }

    function Stroke($aImg,$aX1,$aY1,$aX2,$aY2) {
        if( $this->iShow ) {
            $aImg->PushColor($this->iColor);
            $oldls = $aImg->line_style;
            $oldlw = $aImg->line_weight;
            $aImg->SetLineWeight($this->iWeight);
            $aImg->SetLineStyle($this->iStyle);
            $aImg->StyleLine($aX1,$aY1,$aX2,$aY2);
            $aImg->PopColor($this->iColor);
            $aImg->line_style = $oldls;
            $aImg->line_weight = $oldlw;

        }
    }
}

//===================================================
// CLASS GraphTabTitle
// Description: Draw "tab" titles on top of graphs
//===================================================
class GraphTabTitle extends Text{
    private $corner = 6 , $posx = 7, $posy = 4;
    private $fillcolor='lightyellow',$bordercolor='black';
    private $align = 'left', $width=TABTITLE_WIDTHFIT;
    function __construct() {
        $this->t = '';
        $this->font_style = FS_BOLD;
        $this->hide = true;
        $this->color = 'darkred';
    }

    function SetColor($aTxtColor,$aFillColor='lightyellow',$aBorderColor='black') {
        $this->color = $aTxtColor;
        $this->fillcolor = $aFillColor;
        $this->bordercolor = $aBorderColor;
    }

    function SetFillColor($aFillColor) {
        $this->fillcolor = $aFillColor;
    }

    function SetTabAlign($aAlign) {
        $this->align = $aAlign;
    }

    function SetWidth($aWidth) {
        $this->width = $aWidth ;
    }

    function Set($t) {
        $this->t = $t;
        $this->hide = false;
    }

    function SetCorner($aD) {
        $this->corner = $aD ;
    }

    function Stroke($aImg,$aDummy1=null,$aDummy2=null) {
        if( $this->hide )
            return;
        $this->boxed = false;
        $w = $this->GetWidth($aImg) + 2*$this->posx;
        $h = $this->GetTextHeight($aImg) + 2*$this->posy;

        $x = $aImg->left_margin;
        $y = $aImg->top_margin;

        if( $this->width === TABTITLE_WIDTHFIT ) {
            if( $this->align == 'left' ) {
                $p = array($x,                $y,
                $x,                $y-$h+$this->corner,
                $x + $this->corner,$y-$h,
                $x + $w - $this->corner, $y-$h,
                $x + $w, $y-$h+$this->corner,
                $x + $w, $y);
            }
            elseif( $this->align == 'center' ) {
                $x += round($aImg->plotwidth/2) - round($w/2);
                $p = array($x, $y,
                $x, $y-$h+$this->corner,
                $x + $this->corner, $y-$h,
                $x + $w - $this->corner, $y-$h,
                $x + $w, $y-$h+$this->corner,
                $x + $w, $y);
            }
            else {
                $x += $aImg->plotwidth -$w;
                $p = array($x, $y,
                $x, $y-$h+$this->corner,
                $x + $this->corner,$y-$h,
                $x + $w - $this->corner, $y-$h,
                $x + $w, $y-$h+$this->corner,
                $x + $w, $y);
            }
        }
        else {
            if( $this->width === TABTITLE_WIDTHFULL ) {
                $w = $aImg->plotwidth ;
            }
            else {
                $w = $this->width ;
            }

            // Make the tab fit the width of the plot area
            $p = array($x, $y,
            $x, $y-$h+$this->corner,
            $x + $this->corner,$y-$h,
            $x + $w - $this->corner, $y-$h,
            $x + $w, $y-$h+$this->corner,
            $x + $w, $y);

        }
        if( $this->halign == 'left' ) {
            $aImg->SetTextAlign('left','bottom');
            $x += $this->posx;
            $y -= $this->posy;
        }
        elseif( $this->halign == 'center' ) {
            $aImg->SetTextAlign('center','bottom');
            $x += $w/2;
            $y -= $this->posy;
        }
        else {
            $aImg->SetTextAlign('right','bottom');
            $x += $w - $this->posx;
            $y -= $this->posy;
        }

        $aImg->SetColor($this->fillcolor);
        $aImg->FilledPolygon($p);

        $aImg->SetColor($this->bordercolor);
        $aImg->Polygon($p,true);

        $aImg->SetColor($this->color);
        $aImg->SetFont($this->font_family,$this->font_style,$this->font_size);
        $aImg->StrokeText($x,$y,$this->t,0,'center');
    }

}

//===================================================
// CLASS SuperScriptText
// Description: Format a superscript text
//===================================================
class SuperScriptText extends Text {
    private $iSuper='';
    private $sfont_family='',$sfont_style='',$sfont_size=8;
    private $iSuperMargin=2,$iVertOverlap=4,$iSuperScale=0.65;
    private $iSDir=0;
    private $iSimple=false;

    function __construct($aTxt='',$aSuper='',$aXAbsPos=0,$aYAbsPos=0) {
        parent::__construct($aTxt,$aXAbsPos,$aYAbsPos);
        $this->iSuper = $aSuper;
    }

    function FromReal($aVal,$aPrecision=2) {
        // Convert a floating point number to scientific notation
        $neg=1.0;
        if( $aVal < 0 ) {
            $neg = -1.0;
            $aVal = -$aVal;
        }

        $l = floor(log10($aVal));
        $a = sprintf("%0.".$aPrecision."f",round($aVal / pow(10,$l),$aPrecision));
        $a *= $neg;
        if( $this->iSimple && ($a == 1 || $a==-1) ) $a = '';

        if( $a != '' ) {
            $this->t = $a.' * 10';
        }
        else {
            if( $neg == 1 ) {
                $this->t = '10';
            }
            else {
                $this->t = '-10';
            }
        }
        $this->iSuper = $l;
    }

    function Set($aTxt,$aSuper='') {
        $this->t = $aTxt;
        $this->iSuper = $aSuper;
    }

    function SetSuperFont($aFontFam,$aFontStyle=FS_NORMAL,$aFontSize=8) {
        $this->sfont_family = $aFontFam;
        $this->sfont_style = $aFontStyle;
        $this->sfont_size = $aFontSize;
    }

    // Total width of text
    function GetWidth($aImg) {
        $aImg->SetFont($this->font_family,$this->font_style,$this->font_size);
        $w = $aImg->GetTextWidth($this->t);
        $aImg->SetFont($this->sfont_family,$this->sfont_style,$this->sfont_size);
        $w += $aImg->GetTextWidth($this->iSuper);
        $w += $this->iSuperMargin;
        return $w;
    }

    // Hight of font (approximate the height of the text)
    function GetFontHeight($aImg) {
        $aImg->SetFont($this->font_family,$this->font_style,$this->font_size);
        $h = $aImg->GetFontHeight();
        $aImg->SetFont($this->sfont_family,$this->sfont_style,$this->sfont_size);
        $h += $aImg->GetFontHeight();
        return $h;
    }

    // Hight of text
    function GetTextHeight($aImg) {
        $aImg->SetFont($this->font_family,$this->font_style,$this->font_size);
        $h = $aImg->GetTextHeight($this->t);
        $aImg->SetFont($this->sfont_family,$this->sfont_style,$this->sfont_size);
        $h += $aImg->GetTextHeight($this->iSuper);
        return $h;
    }

    function Stroke($aImg,$ax=-1,$ay=-1) {

        // To position the super script correctly we need different
        // cases to handle the alignmewnt specified since that will
        // determine how we can interpret the x,y coordinates

        $w = parent::GetWidth($aImg);
        $h = parent::GetTextHeight($aImg);
        switch( $this->valign ) {
            case 'top':
                $sy = $this->y;
                break;
            case 'center':
                $sy = $this->y - $h/2;
                break;
            case 'bottom':
                $sy = $this->y - $h;
                break;
            default:
                JpGraphError::RaiseL(25052);//('PANIC: Internal error in SuperScript::Stroke(). Unknown vertical alignment for text');
                break;
        }

        switch( $this->halign ) {
            case 'left':
                $sx = $this->x + $w;
                break;
            case 'center':
                $sx = $this->x + $w/2;
                break;
            case 'right':
                $sx = $this->x;
                break;
            default:
                JpGraphError::RaiseL(25053);//('PANIC: Internal error in SuperScript::Stroke(). Unknown horizontal alignment for text');
                break;
        }

        $sx += $this->iSuperMargin;
        $sy += $this->iVertOverlap;

        // Should we automatically determine the font or
        // has the user specified it explicetly?
        if( $this->sfont_family == '' ) {
            if( $this->font_family <= FF_FONT2 ) {
                if( $this->font_family == FF_FONT0 ) {
                    $sff = FF_FONT0;
                }
                elseif( $this->font_family == FF_FONT1 ) {
                    if( $this->font_style == FS_NORMAL ) {
                        $sff = FF_FONT0;
                    }
                    else {
                        $sff = FF_FONT1;
                    }
                }
                else {
                    $sff = FF_FONT1;
                }
                $sfs = $this->font_style;
                $sfz = $this->font_size;
            }
            else {
                // TTF fonts
                $sff = $this->font_family;
                $sfs = $this->font_style;
                $sfz = floor($this->font_size*$this->iSuperScale);
                if( $sfz < 8 ) $sfz = 8;
            }
            $this->sfont_family = $sff;
            $this->sfont_style = $sfs;
            $this->sfont_size = $sfz;
        }
        else {
            $sff = $this->sfont_family;
            $sfs = $this->sfont_style;
            $sfz = $this->sfont_size;
        }

        parent::Stroke($aImg,$ax,$ay);

        // For the builtin fonts we need to reduce the margins
        // since the bounding bx reported for the builtin fonts
        // are much larger than for the TTF fonts.
        if( $sff <= FF_FONT2 ) {
            $sx -= 2;
            $sy += 3;
        }

        $aImg->SetTextAlign('left','bottom');
        $aImg->SetFont($sff,$sfs,$sfz);
        $aImg->PushColor($this->color);
        $aImg->StrokeText($sx,$sy,$this->iSuper,$this->iSDir,'left');
        $aImg->PopColor();
    }
}


//===================================================
// CLASS Grid
// Description: responsible for drawing grid lines in graph
//===================================================
class Grid {
    protected $img;
    protected $scale;
    protected $majorcolor='#CCCCCC',$minorcolor='#DDDDDD';
    protected $majortype='solid',$minortype='solid';
    protected $show=false, $showMinor=false,$majorweight=1,$minorweight=1;
    protected $fill=false,$fillcolor=array('#EFEFEF','#BBCCFF');

    function __construct($aAxis) {
        $this->scale = $aAxis->scale;
        $this->img = $aAxis->img;
    }

    function SetColor($aMajColor,$aMinColor=false) {
        $this->majorcolor=$aMajColor;
        if( $aMinColor === false ) {
            $aMinColor = $aMajColor ;
        }
        $this->minorcolor = $aMinColor;
    }

    function SetWeight($aMajorWeight,$aMinorWeight=1) {
        $this->majorweight=$aMajorWeight;
        $this->minorweight=$aMinorWeight;
    }

    // Specify if grid should be dashed, dotted or solid
    function SetLineStyle($aMajorType,$aMinorType='solid') {
        $this->majortype = $aMajorType;
        $this->minortype = $aMinorType;
    }

    function SetStyle($aMajorType,$aMinorType='solid') {
        $this->SetLineStyle($aMajorType,$aMinorType);
    }

    // Decide if both major and minor grid should be displayed
    function Show($aShowMajor=true,$aShowMinor=false) {
        $this->show=$aShowMajor;
        $this->showMinor=$aShowMinor;
    }

    function SetFill($aFlg=true,$aColor1='lightgray',$aColor2='lightblue') {
        $this->fill = $aFlg;
        $this->fillcolor = array( $aColor1, $aColor2 );
    }

    // Display the grid
    function Stroke() {
        if( $this->showMinor && !$this->scale->textscale ) {
            $this->DoStroke($this->scale->ticks->ticks_pos,$this->minortype,$this->minorcolor,$this->minorweight);
            $this->DoStroke($this->scale->ticks->maj_ticks_pos,$this->majortype,$this->majorcolor,$this->majorweight);
        }
        else {
            $this->DoStroke($this->scale->ticks->maj_ticks_pos,$this->majortype,$this->majorcolor,$this->majorweight);
        }
    }

    //--------------
    // Private methods
    // Draw the grid
    function DoStroke($aTicksPos,$aType,$aColor,$aWeight) {
        if( !$this->show ) return;
        $nbrgrids = count($aTicksPos);

        if( $this->scale->type == 'y' ) {
            $xl=$this->img->left_margin;
            $xr=$this->img->width-$this->img->right_margin;

            if( $this->fill ) {
                // Draw filled areas
                $y2 = $aTicksPos[0];
                $i=1;
                while( $i < $nbrgrids ) {
                    $y1 = $y2;
                    $y2 = $aTicksPos[$i++];
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($xl,$y1,$xr,$y2);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // Draw grid lines
            switch( $aType ) {
                case 'solid':  $style = LINESTYLE_SOLID; break;
                case 'dotted': $style = LINESTYLE_DOTTED; break;
                case 'dashed': $style = LINESTYLE_DASHED; break;
                case 'longdashed': $style = LINESTYLE_LONGDASH; break;
                default:
                    $style = LINESTYLE_SOLID; break;
            }

            for($i=0; $i < $nbrgrids; ++$i) {
                $y=$aTicksPos[$i];
                $this->img->StyleLine($xl,$y,$xr,$y,$style,true);
            }
        }
        elseif( $this->scale->type == 'x' ) {
            $yu=$this->img->top_margin;
            $yl=$this->img->height-$this->img->bottom_margin;
            $limit=$this->img->width-$this->img->right_margin;

            if( $this->fill ) {
                // Draw filled areas
                $x2 = $aTicksPos[0];
                $i=1;
                while( $i < $nbrgrids ) {
                    $x1 = $x2;
                    $x2 = min($aTicksPos[$i++],$limit) ;
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($x1,$yu,$x2,$yl);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // We must also test for limit since we might have
            // an offset and the number of ticks is calculated with
            // assumption offset==0 so we might end up drawing one
            // to many gridlines
            $i=0;
            $x=$aTicksPos[$i];
            while( $i<count($aTicksPos) && ($x=$aTicksPos[$i]) <= $limit ) {
                if    ( $aType == 'solid' )      $this->img->Line($x,$yl,$x,$yu);
                elseif( $aType == 'dotted' )     $this->img->DashedLineForGrid($x,$yl,$x,$yu,1,6);
                elseif( $aType == 'dashed' )     $this->img->DashedLineForGrid($x,$yl,$x,$yu,2,4);
                elseif( $aType == 'longdashed' ) $this->img->DashedLineForGrid($x,$yl,$x,$yu,8,6);
                ++$i;
            }
        }
        else {
            JpGraphError::RaiseL(25054,$this->scale->type);//('Internal error: Unknown grid axis ['.$this->scale->type.']');
        }
        return true;
    }
} // Class

//===================================================
// CLASS Axis
// Description: Defines X and Y axis. Notes that at the
// moment the code is not really good since the axis on
// several occasion must know wheter it's an X or Y axis.
// This was a design decision to make the code easier to
// follow.
//===================================================
class AxisPrototype {
    public $scale=null;
    public $img=null;
    public $hide=false,$hide_labels=false;
    public $title=null;
    public $font_family=FF_DEFAULT,$font_style=FS_NORMAL,$font_size=8,$label_angle=0;
    public $tick_step=1;
    public $pos = false;
    public $ticks_label = array();

    protected $weight=1;
    protected $color=array(0,0,0),$label_color=array(0,0,0);
    protected $ticks_label_colors=null;
    protected $show_first_label=true,$show_last_label=true;
    protected $label_step=1; // Used by a text axis to specify what multiple of major steps
    // should be labeled.
    protected $labelPos=0;   // Which side of the axis should the labels be?
    protected $title_adjust,$title_margin,$title_side=SIDE_LEFT;
    protected $tick_label_margin=5;
    protected $label_halign = '',$label_valign = '', $label_para_align='left';
    protected $hide_line=false;
    protected $iDeltaAbsPos=0;

    function __construct($img,$aScale,$color = array(0,0,0)) {
        $this->img = $img;
        $this->scale = $aScale;
        $this->color = $color;
        $this->title=new Text('');

        if( $aScale->type == 'y' ) {
            $this->title_margin = 25;
            $this->title_adjust = 'middle';
            $this->title->SetOrientation(90);
            $this->tick_label_margin=7;
            $this->labelPos=SIDE_LEFT;
        }
        else {
            $this->title_margin = 5;
            $this->title_adjust = 'high';
            $this->title->SetOrientation(0);
            $this->tick_label_margin=5;
            $this->labelPos=SIDE_DOWN;
            $this->title_side=SIDE_DOWN;
        }
    }

    function SetLabelFormat($aFormStr) {
        $this->scale->ticks->SetLabelFormat($aFormStr);
    }

    function SetLabelFormatString($aFormStr,$aDate=false) {
        $this->scale->ticks->SetLabelFormat($aFormStr,$aDate);
    }

    function SetLabelFormatCallback($aFuncName) {
        $this->scale->ticks->SetFormatCallback($aFuncName);
    }

    function SetLabelAlign($aHAlign,$aVAlign='top',$aParagraphAlign='left') {
        $this->label_halign = $aHAlign;
        $this->label_valign = $aVAlign;
        $this->label_para_align = $aParagraphAlign;
    }

    // Don't display the first label
    function HideFirstTickLabel($aShow=false) {
        $this->show_first_label=$aShow;
    }

    function HideLastTickLabel($aShow=false) {
        $this->show_last_label=$aShow;
    }

    // Manually specify the major and (optional) minor tick position and labels
    function SetTickPositions($aMajPos,$aMinPos=NULL,$aLabels=NULL) {
        $this->scale->ticks->SetTickPositions($aMajPos,$aMinPos,$aLabels);
    }

    // Manually specify major tick positions and optional labels
    function SetMajTickPositions($aMajPos,$aLabels=NULL) {
        $this->scale->ticks->SetTickPositions($aMajPos,NULL,$aLabels);
    }

    // Hide minor or major tick marks
    function HideTicks($aHideMinor=true,$aHideMajor=true) {
        $this->scale->ticks->SupressMinorTickMarks($aHideMinor);
        $this->scale->ticks->SupressTickMarks($aHideMajor);
    }

    // Hide zero label
    function HideZeroLabel($aFlag=true) {
        $this->scale->ticks->SupressZeroLabel();
    }

    function HideFirstLastLabel() {
        // The two first calls to ticks method will supress
        // automatically generated scale values. However, that
        // will not affect manually specified value, e.g text-scales.
        // therefor we also make a kludge here to supress manually
        // specified scale labels.
        $this->scale->ticks->SupressLast();
        $this->scale->ticks->SupressFirst();
        $this->show_first_label = false;
        $this->show_last_label = false;
    }

    // Hide the axis
    function Hide($aHide=true) {
        $this->hide=$aHide;
    }

    // Hide the actual axis-line, but still print the labels
    function HideLine($aHide=true) {
        $this->hide_line = $aHide;
    }

    function HideLabels($aHide=true) {
        $this->hide_labels = $aHide;
    }

    // Weight of axis
    function SetWeight($aWeight) {
        $this->weight = $aWeight;
    }

    // Axis color
    function SetColor($aColor,$aLabelColor=false) {
        $this->color = $aColor;
        if( !$aLabelColor ) $this->label_color = $aColor;
        else $this->label_color = $aLabelColor;
    }

    // Title on axis
    function SetTitle($aTitle,$aAdjustAlign='high') {
        $this->title->Set($aTitle);
        $this->title_adjust=$aAdjustAlign;
    }

    // Specify distance from the axis
    function SetTitleMargin($aMargin) {
        $this->title_margin=$aMargin;
    }

    // Which side of the axis should the axis title be?
    function SetTitleSide($aSideOfAxis) {
        $this->title_side = $aSideOfAxis;
    }

    function SetTickSide($aDir) {
        $this->scale->ticks->SetSide($aDir);
    }

    function SetTickSize($aMajSize,$aMinSize=3) {
        $this->scale->ticks->SetSize($aMajSize,$aMinSize=3);
    }

    // Specify text labels for the ticks. One label for each data point
    function SetTickLabels($aLabelArray,$aLabelColorArray=null) {
        $this->ticks_label = $aLabelArray;
        $this->ticks_label_colors = $aLabelColorArray;
    }

    function SetLabelMargin($aMargin) {
        $this->tick_label_margin=$aMargin;
    }

    // Specify that every $step of the ticks should be displayed starting
    // at $start
    function SetTextTickInterval($aStep,$aStart=0) {
        $this->scale->ticks->SetTextLabelStart($aStart);
        $this->tick_step=$aStep;
    }

    // Specify that every $step tick mark should have a label
    // should be displayed starting
    function SetTextLabelInterval($aStep) {
        if( $aStep < 1 ) {
            JpGraphError::RaiseL(25058);//(" Text label interval must be specified >= 1.");
        }
        $this->label_step=$aStep;
    }

    function SetLabelSide($aSidePos) {
        $this->labelPos=$aSidePos;
    }

    // Set the font
    function SetFont($aFamily,$aStyle=FS_NORMAL,$aSize=10) {
        $this->font_family = $aFamily;
        $this->font_style = $aStyle;
        $this->font_size = $aSize;
    }

    // Position for axis line on the "other" scale
    function SetPos($aPosOnOtherScale) {
        $this->pos=$aPosOnOtherScale;
    }

    // Set the position of the axis to be X-pixels delta to the right
    // of the max X-position (used to position the multiple Y-axis)
    function SetPosAbsDelta($aDelta) {
        $this->iDeltaAbsPos=$aDelta;
    }

    // Specify the angle for the tick labels
    function SetLabelAngle($aAngle) {
        $this->label_angle = $aAngle;
    }

} // Class


//===================================================
// CLASS Axis
// Description: Defines X and Y axis. Notes that at the
// moment the code is not really good since the axis on
// several occasion must know wheter it's an X or Y axis.
// This was a design decision to make the code easier to
// follow.
//===================================================
class Axis extends AxisPrototype {

    function __construct($img,$aScale,$color='black') {
        parent::__construct($img,$aScale,$color);
    }

    // Stroke the axis.
    function Stroke($aOtherAxisScale,$aStrokeLabels=true) {
        if( $this->hide )
            return;
        if( is_numeric($this->pos) ) {
            $pos=$aOtherAxisScale->Translate($this->pos);
        }
        else { // Default to minimum of other scale if pos not set
            if( ($aOtherAxisScale->GetMinVal() >= 0 && $this->pos==false) || $this->pos == 'min' ) {
                $pos = $aOtherAxisScale->scale_abs[0];
            }
            elseif($this->pos == "max") {
                $pos = $aOtherAxisScale->scale_abs[1];
            }
            else { // If negative set x-axis at 0
                $this->pos=0;
                $pos=$aOtherAxisScale->Translate(0);
            }
        }

        $pos += $this->iDeltaAbsPos;
        $this->img->SetLineWeight($this->weight);
        $this->img->SetColor($this->color);
        $this->img->SetFont($this->font_family,$this->font_style,$this->font_size);

        if( $this->scale->type == "x" ) {
            if( !$this->hide_line ) {
                // Stroke X-axis
                $this->img->FilledRectangle(
                    $this->img->left_margin,
                    $pos,
                    $this->img->width - $this->img->right_margin,
                    $pos + $this->weight-1
                );
            }
            if( $this->title_side == SIDE_DOWN ) {
                $y = $pos + $this->img->GetFontHeight() + $this->title_margin + $this->title->margin;
                $yalign = 'top';
            }
            else {
                $y = $pos - $this->img->GetFontHeight() - $this->title_margin - $this->title->margin;
                $yalign = 'bottom';
            }

            if( $this->title_adjust=='high' ) {
                $this->title->SetPos($this->img->width-$this->img->right_margin,$y,'right',$yalign);
            }
            elseif( $this->title_adjust=='middle' || $this->title_adjust=='center' ) {
                $this->title->SetPos(($this->img->width-$this->img->left_margin-$this->img->right_margin)/2+$this->img->left_margin,$y,'center',$yalign);
            }
            elseif($this->title_adjust=='low') {
                $this->title->SetPos($this->img->left_margin,$y,'left',$yalign);
            }
            else {
                JpGraphError::RaiseL(25060,$this->title_adjust);//('Unknown alignment specified for X-axis title. ('.$this->title_adjust.')');
            }
        }
        elseif( $this->scale->type == "y" ) {
            // Add line weight to the height of the axis since
            // the x-axis could have a width>1 and we want the axis to fit nicely together.
            if( !$this->hide_line ) {
                // Stroke Y-axis
                $this->img->FilledRectangle(
                    $pos - $this->weight + 1, 
                    $this->img->top_margin,
                    $pos,
                    $this->img->height - $this->img->bottom_margin + $this->weight - 1
                );
            }

            $x=$pos ;
            if( $this->title_side == SIDE_LEFT ) {
                $x -= $this->title_margin;
                $x -= $this->title->margin;
                $halign = 'right';
            }
            else {
                $x += $this->title_margin;
                $x += $this->title->margin;
                $halign = 'left';
            }
            // If the user has manually specified an hor. align
            // then we override the automatic settings with this
            // specifed setting. Since default is 'left' we compare
            // with that. (This means a manually set 'left' align
            // will have no effect.)
            if( $this->title->halign != 'left' ) {
                $halign = $this->title->halign;
            }
            if( $this->title_adjust == 'high' ) {
                $this->title->SetPos($x,$this->img->top_margin,$halign,'top');
            }
            elseif($this->title_adjust=='middle' || $this->title_adjust=='center') {
                $this->title->SetPos($x,($this->img->height-$this->img->top_margin-$this->img->bottom_margin)/2+$this->img->top_margin,$halign,"center");
            }
            elseif($this->title_adjust=='low') {
                $this->title->SetPos($x,$this->img->height-$this->img->bottom_margin,$halign,'bottom');
            }
            else {
                JpGraphError::RaiseL(25061,$this->title_adjust);//('Unknown alignment specified for Y-axis title. ('.$this->title_adjust.')');
            }
        }
        $this->scale->ticks->Stroke($this->img,$this->scale,$pos);
        if( $aStrokeLabels ) {
            if( !$this->hide_labels ) {
                $this->StrokeLabels($pos);
            }
            $this->title->Stroke($this->img);
        }
    }

    //---------------
    // PRIVATE METHODS
    // Draw all the tick labels on major tick marks
    function StrokeLabels($aPos,$aMinor=false,$aAbsLabel=false) {

        if( is_array($this->label_color) && count($this->label_color) > 3 ) {
            $this->ticks_label_colors = $this->label_color;
            $this->img->SetColor($this->label_color[0]);
        }
        else {
            $this->img->SetColor($this->label_color);
        }
        $this->img->SetFont($this->font_family,$this->font_style,$this->font_size);
        $yoff=$this->img->GetFontHeight()/2;

        // Only draw labels at major tick marks
        $nbr = count($this->scale->ticks->maj_ticks_label);

        // We have the option to not-display the very first mark
        // (Usefull when the first label might interfere with another
        // axis.)
        $i = $this->show_first_label ? 0 : 1 ;
        if( !$this->show_last_label ) {
            --$nbr;
        }
        // Now run through all labels making sure we don't overshoot the end
        // of the scale.
        $ncolor=0;
        if( isset($this->ticks_label_colors) ) {
            $ncolor=count($this->ticks_label_colors);
        }
        while( $i < $nbr ) {
            // $tpos holds the absolute text position for the label
            $tpos=$this->scale->ticks->maj_ticklabels_pos[$i];

            // Note. the $limit is only used for the x axis since we
            // might otherwise overshoot if the scale has been centered
            // This is due to us "loosing" the last tick mark if we center.
            if( $this->scale->type == 'x' && $tpos > $this->img->width-$this->img->right_margin+1 ) {
                return;
            }
            // we only draw every $label_step label
            if( ($i % $this->label_step)==0 ) {

                // Set specific label color if specified
                if( $ncolor > 0 ) {
                    $this->img->SetColor($this->ticks_label_colors[$i % $ncolor]);
                }

                // If the label has been specified use that and in other case
                // just label the mark with the actual scale value
                $m=$this->scale->ticks->GetMajor();

                // ticks_label has an entry for each data point and is the array
                // that holds the labels set by the user. If the user hasn't
                // specified any values we use whats in the automatically asigned
                // labels in the maj_ticks_label
                if( isset($this->ticks_label[$i*$m]) ) {
                    $label=$this->ticks_label[$i*$m];
                }
                else {
                    if( $aAbsLabel ) {
                        $label=abs($this->scale->ticks->maj_ticks_label[$i]);
                    }
                    else {
                        $label=$this->scale->ticks->maj_ticks_label[$i];
                    }

                    // We number the scale from 1 and not from 0 so increase by one
                    if( $this->scale->textscale && 
                        $this->scale->ticks->label_formfunc == '' &&
                        ! $this->scale->ticks->HaveManualLabels() ) {

                        ++$label;
                        
                    }
                }

                if( $this->scale->type == "x" ) {
                    if( $this->labelPos == SIDE_DOWN ) {
                        if( $this->label_angle==0 || $this->label_angle==90 ) {
                            if( $this->label_halign=='' && $this->label_valign=='') {
                                $this->img->SetTextAlign('center','top');
                            }
                            else {
                                $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                            }

                        }
                        else {
                            if( $this->label_halign=='' && $this->label_valign=='') {
                                $this->img->SetTextAlign("right","top");
                            }
                            else {
                                $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                            }
                        }
                        $this->img->StrokeText($tpos,$aPos+$this->tick_label_margin,$label,
                        $this->label_angle,$this->label_para_align);
                    }
                    else {
                        if( $this->label_angle==0 || $this->label_angle==90 ) {
                            if( $this->label_halign=='' && $this->label_valign=='') {
                                $this->img->SetTextAlign("center","bottom");
                            }
                            else {
                                $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                            }
                        }
                        else {
                            if( $this->label_halign=='' && $this->label_valign=='') {
                                $this->img->SetTextAlign("right","bottom");
                            }
                            else {
                                $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                            }
                        }
                        $this->img->StrokeText($tpos,$aPos-$this->tick_label_margin-1,$label,
                        $this->label_angle,$this->label_para_align);
                    }
                }
                else {
                    // scale->type == "y"
                    //if( $this->label_angle!=0 )
                    //JpGraphError::Raise(" Labels at an angle are not supported on Y-axis");
                    if( $this->labelPos == SIDE_LEFT ) { // To the left of y-axis
                        if( $this->label_halign=='' && $this->label_valign=='') {
                            $this->img->SetTextAlign("right","center");
                        }
                        else {
                            $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                        }
                        $this->img->StrokeText($aPos-$this->tick_label_margin,$tpos,$label,$this->label_angle,$this->label_para_align);
                    }
                    else { // To the right of the y-axis
                        if( $this->label_halign=='' && $this->label_valign=='') {
                            $this->img->SetTextAlign("left","center");
                        }
                        else {
                            $this->img->SetTextAlign($this->label_halign,$this->label_valign);
                        }
                        $this->img->StrokeText($aPos+$this->tick_label_margin,$tpos,$label,$this->label_angle,$this->label_para_align);
                    }
                }
            }
            ++$i;
        }
    }

}


//===================================================
// CLASS Ticks
// Description: Abstract base class for drawing linear and logarithmic
// tick marks on axis
//===================================================
class Ticks {
    public $label_formatstr='';   // C-style format string to use for labels
    public $label_formfunc='';
    public $label_dateformatstr='';
    public $direction=1; // Should ticks be in(=1) the plot area or outside (=-1)
    public $supress_last=false,$supress_tickmarks=false,$supress_minor_tickmarks=false;
    public $maj_ticks_pos = array(), $maj_ticklabels_pos = array(),
           $ticks_pos = array(), $maj_ticks_label = array();
    public $precision;

    protected $minor_abs_size=3, $major_abs_size=5;
    protected $scale;
    protected $is_set=false;
    protected $supress_zerolabel=false,$supress_first=false;
    protected $mincolor='',$majcolor='';
    protected $weight=1;
    protected $label_usedateformat=FALSE;

    function __construct($aScale) {
        $this->scale=$aScale;
        $this->precision = -1;
    }

    // Set format string for automatic labels
    function SetLabelFormat($aFormatString,$aDate=FALSE) {
        $this->label_formatstr=$aFormatString;
        $this->label_usedateformat=$aDate;
    }

    function SetLabelDateFormat($aFormatString) {
        $this->label_dateformatstr=$aFormatString;
    }

    function SetFormatCallback($aCallbackFuncName) {
        $this->label_formfunc = $aCallbackFuncName;
    }

    // Don't display the first zero label
    function SupressZeroLabel($aFlag=true) {
        $this->supress_zerolabel=$aFlag;
    }

    // Don't display minor tick marks
    function SupressMinorTickMarks($aHide=true) {
        $this->supress_minor_tickmarks=$aHide;
    }

    // Don't display major tick marks
    function SupressTickMarks($aHide=true) {
        $this->supress_tickmarks=$aHide;
    }

    // Hide the first tick mark
    function SupressFirst($aHide=true) {
        $this->supress_first=$aHide;
    }

    // Hide the last tick mark
    function SupressLast($aHide=true) {
        $this->supress_last=$aHide;
    }

    // Size (in pixels) of minor tick marks
    function GetMinTickAbsSize() {
        return $this->minor_abs_size;
    }

    // Size (in pixels) of major tick marks
    function GetMajTickAbsSize() {
        return $this->major_abs_size;
    }

    function SetSize($aMajSize,$aMinSize=3) {
        $this->major_abs_size = $aMajSize;
        $this->minor_abs_size = $aMinSize;
    }

    // Have the ticks been specified
    function IsSpecified() {
        return $this->is_set;
    }

    function SetSide($aSide) {
        $this->direction=$aSide;
    }

    // Which side of the axis should the ticks be on
    function SetDirection($aSide=SIDE_RIGHT) {
        $this->direction=$aSide;
    }

    // Set colors for major and minor tick marks
    function SetMarkColor($aMajorColor,$aMinorColor='') {
        $this->SetColor($aMajorColor,$aMinorColor);
    }

    function SetColor($aMajorColor,$aMinorColor='') {
        $this->majcolor=$aMajorColor;

        // If not specified use same as major
        if( $aMinorColor == '' ) {
            $this->mincolor=$aMajorColor;
        }
        else {
            $this->mincolor=$aMinorColor;
        }
    }

    function SetWeight($aWeight) {
        $this->weight=$aWeight;
    }

} // Class

//===================================================
// CLASS LinearTicks
// Description: Draw linear ticks on axis
//===================================================
class LinearTicks extends Ticks {
    public $minor_step=1, $major_step=2;
    public $xlabel_offset=0,$xtick_offset=0;
    private $label_offset=0; // What offset should the displayed label have
    // i.e should we display 0,1,2 or 1,2,3,4 or 2,3,4 etc
    private $text_label_start=0;
    private $iManualTickPos = NULL, $iManualMinTickPos = NULL, $iManualTickLabels = NULL;
    private $iAdjustForDST = false; // If a date falls within the DST period add one hour to the diaplyed time

    function __construct() {
        $this->precision = -1;
    }

    // Return major step size in world coordinates
    function GetMajor() {
        return $this->major_step;
    }

    // Return minor step size in world coordinates
    function GetMinor() {
        return $this->minor_step;
    }

    // Set Minor and Major ticks (in world coordinates)
    function Set($aMajStep,$aMinStep=false) {
        if( $aMinStep==false ) {
            $aMinStep=$aMajStep;
        }

        if( $aMajStep <= 0 || $aMinStep <= 0 ) {
            JpGraphError::RaiseL(25064);
            //(" Minor or major step size is 0. Check that you haven't got an accidental SetTextTicks(0) in your code. If this is not the case you might have stumbled upon a bug in JpGraph. Please report this and if possible include the data that caused the problem.");
        }

        $this->major_step=$aMajStep;
        $this->minor_step=$aMinStep;
        $this->is_set = true;
    }

    function SetMajTickPositions($aMajPos,$aLabels=NULL) {
        $this->SetTickPositions($aMajPos,NULL,$aLabels);
    }

    function SetTickPositions($aMajPos,$aMinPos=NULL,$aLabels=NULL) {
        if( !is_array($aMajPos) || ($aMinPos!==NULL && !is_array($aMinPos)) ) {
            JpGraphError::RaiseL(25065);//('Tick positions must be specifued as an array()');
            return;
        }
        $n=count($aMajPos);
        if( is_array($aLabels) && (count($aLabels) != $n) ) {
            JpGraphError::RaiseL(25066);//('When manually specifying tick positions and labels the number of labels must be the same as the number of specified ticks.');
        }
        $this->iManualTickPos = $aMajPos;
        $this->iManualMinTickPos = $aMinPos;
        $this->iManualTickLabels = $aLabels;
    }

    function HaveManualLabels() {
        return count($this->iManualTickLabels) > 0;
    }

    // Specify all the tick positions manually and possible also the exact labels
    function _doManualTickPos($aScale) {
        $n=count($this->iManualTickPos);
        $m=count($this->iManualMinTickPos);
        $doLbl=count($this->iManualTickLabels) > 0;

        $this->maj_ticks_pos = array();
        $this->maj_ticklabels_pos = array();
        $this->ticks_pos = array();

        // Now loop through the supplied positions and translate them to screen coordinates
        // and store them in the maj_label_positions
        $minScale = $aScale->scale[0];
        $maxScale = $aScale->scale[1];
        $j=0;
        for($i=0; $i < $n ; ++$i ) {
            // First make sure that the first tick is not lower than the lower scale value
            if( !isset($this->iManualTickPos[$i]) || $this->iManualTickPos[$i] < $minScale  || $this->iManualTickPos[$i] > $maxScale) {
                continue;
            }

            $this->maj_ticks_pos[$j] = $aScale->Translate($this->iManualTickPos[$i]);
            $this->maj_ticklabels_pos[$j] = $this->maj_ticks_pos[$j];

            // Set the minor tick marks the same as major if not specified
            if( $m <= 0 ) {
                $this->ticks_pos[$j] = $this->maj_ticks_pos[$j];
            }
            if( $doLbl ) {
                $this->maj_ticks_label[$j] = $this->iManualTickLabels[$i];
            }
            else {
                $this->maj_ticks_label[$j]=$this->_doLabelFormat($this->iManualTickPos[$i],$i,$n);
            }
            ++$j;
        }

        // Some sanity check
        if( count($this->maj_ticks_pos) < 2 ) {
            JpGraphError::RaiseL(25067);//('Your manually specified scale and ticks is not correct. The scale seems to be too small to hold any of the specified tickl marks.');
        }

        // Setup the minor tick marks
        $j=0;
        for($i=0; $i < $m; ++$i ) {
            if(  empty($this->iManualMinTickPos[$i]) || $this->iManualMinTickPos[$i] < $minScale  || $this->iManualMinTickPos[$i] > $maxScale) {
                continue;
            }
            $this->ticks_pos[$j] = $aScale->Translate($this->iManualMinTickPos[$i]);
            ++$j;
        }
    }

    function _doAutoTickPos($aScale) {
        $maj_step_abs = $aScale->scale_factor*$this->major_step;
        $min_step_abs = $aScale->scale_factor*$this->minor_step;

        if( $min_step_abs==0 || $maj_step_abs==0 ) {
            JpGraphError::RaiseL(25068);//("A plot has an illegal scale. This could for example be that you are trying to use text autoscaling to draw a line plot with only one point or that the plot area is too small. It could also be that no input data value is numeric (perhaps only '-' or 'x')");
        }
        // We need to make this an int since comparing it below
        // with the result from round() can give wrong result, such that
        // (40 < 40) == TRUE !!!
        $limit = (int)$aScale->scale_abs[1];

        if( $aScale->textscale ) {
            // This can only be true for a X-scale (horizontal)
            // Define ticks for a text scale. This is slightly different from a
            // normal linear type of scale since the position might be adjusted
            // and the labels start at on
            $label = (float)$aScale->GetMinVal()+$this->text_label_start+$this->label_offset;
            $start_abs=$aScale->scale_factor*$this->text_label_start;
            $nbrmajticks=round(($aScale->GetMaxVal()-$aScale->GetMinVal()-$this->text_label_start )/$this->major_step)+1;

            $x = $aScale->scale_abs[0]+$start_abs+$this->xlabel_offset*$min_step_abs;
            for( $i=0; $label <= $aScale->GetMaxVal()+$this->label_offset; ++$i ) {
                // Apply format to label
                $this->maj_ticks_label[$i]=$this->_doLabelFormat($label,$i,$nbrmajticks);
                $label+=$this->major_step;

                // The x-position of the tick marks can be different from the labels.
                // Note that we record the tick position (not the label) so that the grid
                // happen upon tick marks and not labels.
                $xtick=$aScale->scale_abs[0]+$start_abs+$this->xtick_offset*$min_step_abs+$i*$maj_step_abs;
                $this->maj_ticks_pos[$i]=$xtick;
                $this->maj_ticklabels_pos[$i] = round($x);
                $x += $maj_step_abs;
            }
        }
        else {
            $label = $aScale->GetMinVal();
            $abs_pos = $aScale->scale_abs[0];
            $j=0; $i=0;
            $step = round($maj_step_abs/$min_step_abs);
            if( $aScale->type == "x" ) {
                // For a normal linear type of scale the major ticks will always be multiples
                // of the minor ticks. In order to avoid any rounding issues the major ticks are
                // defined as every "step" minor ticks and not calculated separately
                $nbrmajticks=round(($aScale->GetMaxVal()-$aScale->GetMinVal()-$this->text_label_start )/$this->major_step)+1;
                while( round($abs_pos) <= $limit ) {
                    $this->ticks_pos[] = round($abs_pos);
                    $this->ticks_label[] = $label;
                    if( $step== 0 || $i % $step == 0 && $j < $nbrmajticks ) {
                        $this->maj_ticks_pos[$j] = round($abs_pos);
                        $this->maj_ticklabels_pos[$j] = round($abs_pos);
                        $this->maj_ticks_label[$j]=$this->_doLabelFormat($label,$j,$nbrmajticks);
                        ++$j;
                    }
                    ++$i;
                    $abs_pos += $min_step_abs;
                    $label+=$this->minor_step;
                }
            }
            elseif( $aScale->type == "y" ) {
                //@todo  s=2:20,12  s=1:50,6  $this->major_step:$nbr
                // abs_point,limit s=1:270,80 s=2:540,160
             // $this->major_step = 50;
                $nbrmajticks=round(($aScale->GetMaxVal()-$aScale->GetMinVal())/$this->major_step)+1;
//                $step = 5;
                while( round($abs_pos) >= $limit ) {
                    $this->ticks_pos[$i] = round($abs_pos);
                    $this->ticks_label[$i]=$label;
                    if( $step== 0 || $i % $step == 0 && $j < $nbrmajticks) {
                        $this->maj_ticks_pos[$j] = round($abs_pos);
                        $this->maj_ticklabels_pos[$j] = round($abs_pos);
                        $this->maj_ticks_label[$j]=$this->_doLabelFormat($label,$j,$nbrmajticks);
                        ++$j;
                    }
                    ++$i;
                    $abs_pos += $min_step_abs;
                    $label += $this->minor_step;
                }
            }
        }
    }

    function AdjustForDST($aFlg=true) {
        $this->iAdjustForDST = $aFlg;
    }


    function _doLabelFormat($aVal,$aIdx,$aNbrTicks) {

        // If precision hasn't been specified set it to a sensible value
        if( $this->precision==-1 ) {
            $t = log10($this->minor_step);
            if( $t > 0 ) {
                $precision = 0;
            }
            else {
                $precision = -floor($t);
            }
        }
        else {
            $precision = $this->precision;
        }

        if( $this->label_formfunc != '' ) {
            $f=$this->label_formfunc;
            if( $this->label_formatstr == '' ) {
                $l = call_user_func($f,$aVal);
            }
            else {
                $l = sprintf($this->label_formatstr, call_user_func($f,$aVal));
            }
        }
        elseif( $this->label_formatstr != '' || $this->label_dateformatstr != '' ) {
            if( $this->label_usedateformat ) {
                // Adjust the value to take daylight savings into account
                if (date("I",$aVal)==1 && $this->iAdjustForDST ) {
                    // DST
                    $aVal+=3600;
                }

                $l = date($this->label_formatstr,$aVal);
                if( $this->label_formatstr == 'W' ) {
                    // If we use week formatting then add a single 'w' in front of the
                    // week number to differentiate it from dates
                    $l = 'w'.$l;
                }
            }
            else {
                if( $this->label_dateformatstr !== '' ) {
                    // Adjust the value to take daylight savings into account
                    if (date("I",$aVal)==1 && $this->iAdjustForDST ) {
                        // DST
                        $aVal+=3600;
                    }

                    $l = date($this->label_dateformatstr,$aVal);
                    if( $this->label_formatstr == 'W' ) {
                        // If we use week formatting then add a single 'w' in front of the
                        // week number to differentiate it from dates
                        $l = 'w'.$l;
                    }
                }
                else {
                    $l = sprintf($this->label_formatstr,$aVal);
                }
            }
        }
        else {
            $l = sprintf('%01.'.$precision.'f',round($aVal,$precision));
        }

        if( ($this->supress_zerolabel && $l==0) ||  ($this->supress_first && $aIdx==0) || ($this->supress_last  && $aIdx==$aNbrTicks-1) ) {
            $l='';
        }
        return $l;
    }

    // Stroke ticks on either X or Y axis
    function _StrokeTicks($aImg,$aScale,$aPos) {
        $hor = $aScale->type == 'x';
        $aImg->SetLineWeight($this->weight);

        // We need to make this an int since comparing it below
        // with the result from round() can give wrong result, such that
        // (40 < 40) == TRUE !!!
        $limit = (int)$aScale->scale_abs[1];

        // A text scale doesn't have any minor ticks
        if( !$aScale->textscale ) {
            // Stroke minor ticks
            $yu = $aPos - $this->direction*$this->GetMinTickAbsSize();
            $xr = $aPos + $this->direction*$this->GetMinTickAbsSize();
            $n = count($this->ticks_pos);
            for($i=0; $i < $n; ++$i ) {
                if( !$this->supress_tickmarks && !$this->supress_minor_tickmarks) {
                    if( $this->mincolor != '') {
                        $aImg->PushColor($this->mincolor);
                    }
                    if( $hor ) {
                        //if( $this->ticks_pos[$i] <= $limit )
                        $aImg->Line($this->ticks_pos[$i],$aPos,$this->ticks_pos[$i],$yu);
                    }
                    else {
                        //if( $this->ticks_pos[$i] >= $limit )
                        $aImg->Line($aPos,$this->ticks_pos[$i],$xr,$this->ticks_pos[$i]);
                    }
                    if( $this->mincolor != '' ) {
                        $aImg->PopColor();
                    }
                }
            }
        }

        // Stroke major ticks
        $yu = $aPos - $this->direction*$this->GetMajTickAbsSize();
        $xr = $aPos + $this->direction*$this->GetMajTickAbsSize();
        $nbrmajticks=round(($aScale->GetMaxVal()-$aScale->GetMinVal()-$this->text_label_start )/$this->major_step)+1;
        $n = count($this->maj_ticks_pos);
        for($i=0; $i < $n ; ++$i ) {
            if(!($this->xtick_offset > 0 && $i==$nbrmajticks-1) && !$this->supress_tickmarks) {
                if( $this->majcolor != '') {
                    $aImg->PushColor($this->majcolor);
                }
                if( $hor ) {
                    //if( $this->maj_ticks_pos[$i] <= $limit )
                    $aImg->Line($this->maj_ticks_pos[$i],$aPos,$this->maj_ticks_pos[$i],$yu);
                }
                else {
                    //if( $this->maj_ticks_pos[$i] >= $limit )
                    $aImg->Line($aPos,$this->maj_ticks_pos[$i],$xr,$this->maj_ticks_pos[$i]);
                }
                if( $this->majcolor != '') {
                    $aImg->PopColor();
                }
            }
        }

    }

    // Draw linear ticks
    function Stroke($aImg,$aScale,$aPos) {
        if( $this->iManualTickPos != NULL ) {
            $this->_doManualTickPos($aScale);
        }
        else {
            $this->_doAutoTickPos($aScale);
        }
        $this->_StrokeTicks($aImg,$aScale,$aPos, $aScale->type == 'x' );
    }

    //---------------
    // PRIVATE METHODS
    // Spoecify the offset of the displayed tick mark with the tick "space"
    // Legal values for $o is [0,1] used to adjust where the tick marks and label
    // should be positioned within the major tick-size
    // $lo specifies the label offset and $to specifies the tick offset
    // this comes in handy for example in bar graphs where we wont no offset for the
    // tick but have the labels displayed halfway under the bars.
    function SetXLabelOffset($aLabelOff,$aTickOff=-1) {
        $this->xlabel_offset=$aLabelOff;
        if( $aTickOff==-1 ) {
            // Same as label offset
            $this->xtick_offset=$aLabelOff;
        }
        else {
            $this->xtick_offset=$aTickOff;
        }
        if( $aLabelOff>0 ) {
            $this->SupressLast(); // The last tick wont fit
        }
    }

    // Which tick label should we start with?
    function SetTextLabelStart($aTextLabelOff) {
        $this->text_label_start=$aTextLabelOff;
    }

} // Class

//===================================================
// CLASS LinearScale
// Description: Handle linear scaling between screen and world
//===================================================
class LinearScale {
    public $textscale=false; // Just a flag to let the Plot class find out if
    // we are a textscale or not. This is a cludge since
    // this information is available in Graph::axtype but
    // we don't have access to the graph object in the Plots
    // stroke method. So we let graph store the status here
    // when the linear scale is created. A real cludge...
    public $type; // is this x or y scale ?
    public $ticks=null; // Store ticks
    public $text_scale_off = 0;
    public $scale_abs=array(0,0);
    public $scale_factor; // Scale factor between world and screen
    public $off; // Offset between image edge and plot area
    public $scale=array(0,0);
    public $name = 'lin';
    public $auto_ticks=false; // When using manual scale should the ticks be automatically set?
    public $world_abs_size; // Plot area size in pixels (Needed public in jpgraph_radar.php)
    public $intscale=false; // Restrict autoscale to integers
    protected $autoscale_min=false; // Forced minimum value, auto determine max
    protected $autoscale_max=false; // Forced maximum value, auto determine min
    private $gracetop=0,$gracebottom=0;

    private $_world_size; // Plot area size in world coordinates

    function __construct($aMin=0,$aMax=0,$aType='y') {
        assert($aType=='x' || $aType=='y' );
        assert($aMin<=$aMax);

        $this->type=$aType;
        $this->scale=array($aMin,$aMax);
        $this->world_size=$aMax-$aMin;
        $this->ticks = new LinearTicks();
    }

    // Check if scale is set or if we should autoscale
    // We should do this is either scale or ticks has not been set
    function IsSpecified() {
        if( $this->GetMinVal()==$this->GetMaxVal() ) {  // Scale not set
            return false;
        }
        return true;
    }

    // Set the minimum data value when the autoscaling is used.
    // Usefull if you want a fix minimum (like 0) but have an
    // automatic maximum
    function SetAutoMin($aMin) {
        $this->autoscale_min=$aMin;
    }

    // Set the minimum data value when the autoscaling is used.
    // Usefull if you want a fix minimum (like 0) but have an
    // automatic maximum
    function SetAutoMax($aMax) {
        $this->autoscale_max=$aMax;
    }

    // If the user manually specifies a scale should the ticks
    // still be set automatically?
    function SetAutoTicks($aFlag=true) {
        $this->auto_ticks = $aFlag;
    }

    // Specify scale "grace" value (top and bottom)
    function SetGrace($aGraceTop,$aGraceBottom=0) {
        if( $aGraceTop<0 || $aGraceBottom < 0  ) {
            JpGraphError::RaiseL(25069);//(" Grace must be larger then 0");
        }
        $this->gracetop=$aGraceTop;
        $this->gracebottom=$aGraceBottom;
    }

    // Get the minimum value in the scale
    function GetMinVal() {
        return $this->scale[0];
    }

    // get maximum value for scale
    function GetMaxVal() {
        return $this->scale[1];
    }

    // Specify a new min/max value for sclae
    function Update($aImg,$aMin,$aMax) {
        $this->scale=array($aMin,$aMax);
        $this->world_size=$aMax-$aMin;
        $this->InitConstants($aImg);
    }

    // Translate between world and screen
    function Translate($aCoord) {
        if( !is_numeric($aCoord) ) {
            if( $aCoord != '' && $aCoord != '-' && $aCoord != 'x' ) {
                JpGraphError::RaiseL(25070);//('Your data contains non-numeric values.');
            }
            return 0;
        }
        else {
            return round($this->off+($aCoord - $this->scale[0]) * $this->scale_factor);
        }
    }

    // Relative translate (don't include offset) usefull when we just want
    // to know the relative position (in pixels) on the axis
    function RelTranslate($aCoord) {
        if( !is_numeric($aCoord) ) {
            if( $aCoord != '' && $aCoord != '-' && $aCoord != 'x'  ) {
                JpGraphError::RaiseL(25070);//('Your data contains non-numeric values.');
            }
            return 0;
        }
        else {
            return ($aCoord - $this->scale[0]) * $this->scale_factor;
        }
    }

    // Restrict autoscaling to only use integers
    function SetIntScale($aIntScale=true) {
        $this->intscale=$aIntScale;
    }

    // Calculate an integer autoscale
    function IntAutoScale($img,$min,$max,$maxsteps,$majend=true) {
        // Make sure limits are integers
        $min=floor($min);
        $max=ceil($max);
        if( abs($min-$max)==0 ) {
            --$min; ++$max;
        }
        $maxsteps = floor($maxsteps);

        $gracetop=round(($this->gracetop/100.0)*abs($max-$min));
        $gracebottom=round(($this->gracebottom/100.0)*abs($max-$min));
        if( is_numeric($this->autoscale_min) ) {
            $min = ceil($this->autoscale_min);
            if( $min >= $max ) {
                JpGraphError::RaiseL(25071);//('You have specified a min value with SetAutoMin() which is larger than the maximum value used for the scale. This is not possible.');
            }
        }

        if( is_numeric($this->autoscale_max) ) {
            $max = ceil($this->autoscale_max);
            if( $min >= $max ) {
                JpGraphError::RaiseL(25072);//('You have specified a max value with SetAutoMax() which is smaller than the miminum value used for the scale. This is not possible.');
            }
        }

        if( abs($min-$max ) == 0 ) {
            ++$max;
            --$min;
        }

        $min -= $gracebottom;
        $max += $gracetop;

        // First get tickmarks as multiples of 1, 10, ...
        if( $majend ) {
            list($num1steps,$adj1min,$adj1max,$maj1step) = $this->IntCalcTicks($maxsteps,$min,$max,1);
        }
        else {
            $adj1min = $min;
            $adj1max = $max;
            list($num1steps,$maj1step) = $this->IntCalcTicksFreeze($maxsteps,$min,$max,1);
        }

        if( abs($min-$max) > 2 ) {
            // Then get tick marks as 2:s 2, 20, ...
            if( $majend ) {
                list($num2steps,$adj2min,$adj2max,$maj2step) = $this->IntCalcTicks($maxsteps,$min,$max,5);
            }
            else {
                $adj2min = $min;
                $adj2max = $max;
                list($num2steps,$maj2step) = $this->IntCalcTicksFreeze($maxsteps,$min,$max,5);
            }
        }
        else {
            $num2steps = 10000; // Dummy high value so we don't choose this
        }

        if( abs($min-$max) > 5 ) {
            // Then get tickmarks as 5:s 5, 50, 500, ...
            if( $majend ) {
                list($num5steps,$adj5min,$adj5max,$maj5step) = $this->IntCalcTicks($maxsteps,$min,$max,2);
            }
            else {
                $adj5min = $min;
                $adj5max = $max;
                list($num5steps,$maj5step) = $this->IntCalcTicksFreeze($maxsteps,$min,$max,2);
            }
        }
        else {
            $num5steps = 10000; // Dummy high value so we don't choose this
        }

        // Check to see whichof 1:s, 2:s or 5:s fit better with
        // the requested number of major ticks
        $match1=abs($num1steps-$maxsteps);
        $match2=abs($num2steps-$maxsteps);
        if( !empty($maj5step) && $maj5step > 1 ) {
            $match5=abs($num5steps-$maxsteps);
        }
        else {
            $match5=10000;  // Dummy high value
        }

        // Compare these three values and see which is the closest match
        // We use a 0.6 weight to gravitate towards multiple of 5:s
        if( $match1 < $match2 ) {
            if( $match1 < $match5 ) $r=1;
            else  $r=3;
        }
        else {
            if( $match2 < $match5 ) $r=2;
            else $r=3;
        }
        // Minsteps are always the same as maxsteps for integer scale
        switch( $r ) {
            case 1:
                $this->ticks->Set($maj1step,$maj1step);
                $this->Update($img,$adj1min,$adj1max);
                break;
            case 2:
                $this->ticks->Set($maj2step,$maj2step);
                $this->Update($img,$adj2min,$adj2max);
                break;
            case 3:
                $this->ticks->Set($maj5step,$maj5step);
                $this->Update($img,$adj5min,$adj5max);
                break;
            default:
                JpGraphError::RaiseL(25073,$r);//('Internal error. Integer scale algorithm comparison out of bound (r=$r)');
        }
    }


    // Calculate autoscale. Used if user hasn't given a scale and ticks
    // $maxsteps is the maximum number of major tickmarks allowed.
    function AutoScale($img,$min,$max,$maxsteps,$majend=true) {

        if( !is_numeric($min) || !is_numeric($max) ) {
            JpGraphError::Raise(25044);
        }

        if( $this->intscale ) {
            $this->IntAutoScale($img,$min,$max,$maxsteps,$majend);
            return;
        }
        if( abs($min-$max) < 0.00001 ) {
            // We need some difference to be able to autoscale
            // make it 5% above and 5% below value
            if( $min==0 && $max==0 ) {  // Special case
                $min=-1; $max=1;
            }
            else {
                $delta = (abs($max)+abs($min))*0.005;
                $min -= $delta;
                $max += $delta;
            }
        }

        $gracetop=($this->gracetop/100.0)*abs($max-$min);
        $gracebottom=($this->gracebottom/100.0)*abs($max-$min);
        if( is_numeric($this->autoscale_min) ) {
            $min = $this->autoscale_min;
            if( $min >= $max ) {
                JpGraphError::RaiseL(25071);//('You have specified a min value with SetAutoMin() which is larger than the maximum value used for the scale. This is not possible.');
            }
            if( abs($min-$max ) < 0.001 ) {
                $max *= 1.2;
            }
        }

        if( is_numeric($this->autoscale_max) ) {
            $max = $this->autoscale_max;
            if( $min >= $max ) {
                JpGraphError::RaiseL(25072);//('You have specified a max value with SetAutoMax() which is smaller than the miminum value used for the scale. This is not possible.');
            }
            if( abs($min-$max ) < 0.001 ) {
                $min *= 0.8;
            }
        }

        $min -= $gracebottom;
        $max += $gracetop;

        // First get tickmarks as multiples of 0.1, 1, 10, ...
        if( $majend ) {
            list($num1steps,$adj1min,$adj1max,$min1step,$maj1step) = $this->CalcTicks($maxsteps,$min,$max,1,2);
        }
        else {
            $adj1min=$min;
            $adj1max=$max;
            list($num1steps,$min1step,$maj1step) = $this->CalcTicksFreeze($maxsteps,$min,$max,1,2,false);
        }

        // Then get tick marks as 2:s 0.2, 2, 20, ...
        if( $majend ) {
            list($num2steps,$adj2min,$adj2max,$min2step,$maj2step) = $this->CalcTicks($maxsteps,$min,$max,5,2);
        }
        else {
            $adj2min=$min;
            $adj2max=$max;
            list($num2steps,$min2step,$maj2step) = $this->CalcTicksFreeze($maxsteps,$min,$max,5,2,false);
        }

        // Then get tickmarks as 5:s 0.05, 0.5, 5, 50, ...
        if( $majend ) {
            list($num5steps,$adj5min,$adj5max,$min5step,$maj5step) = $this->CalcTicks($maxsteps,$min,$max,2,5);
        }
        else {
            $adj5min=$min;
            $adj5max=$max;
            list($num5steps,$min5step,$maj5step) = $this->CalcTicksFreeze($maxsteps,$min,$max,2,5,false);
        }

        // Check to see whichof 1:s, 2:s or 5:s fit better with
        // the requested number of major ticks
        $match1=abs($num1steps-$maxsteps);
        $match2=abs($num2steps-$maxsteps);
        $match5=abs($num5steps-$maxsteps);

        // Compare these three values and see which is the closest match
        // We use a 0.8 weight to gravitate towards multiple of 5:s
        $r=$this->MatchMin3($match1,$match2,$match5,0.8);
        switch( $r ) {
            case 1:
                $this->Update($img,$adj1min,$adj1max);
                $this->ticks->Set($maj1step,$min1step);
                break;
            case 2:
                $this->Update($img,$adj2min,$adj2max);
                $this->ticks->Set($maj2step,$min2step);
                break;
            case 3:
                $this->Update($img,$adj5min,$adj5max);
                $this->ticks->Set($maj5step,$min5step);
                break;
        }
    }

    //---------------
    // PRIVATE METHODS

    // This method recalculates all constants that are depending on the
    // margins in the image. If the margins in the image are changed
    // this method should be called for every scale that is registred with
    // that image. Should really be installed as an observer of that image.
    function InitConstants($img) {
        if( $this->type=='x' ) {
            $this->world_abs_size=$img->width - $img->left_margin - $img->right_margin;
            $this->off=$img->left_margin;
            $this->scale_factor = 0;
            if( $this->world_size > 0 ) {
                $this->scale_factor=$this->world_abs_size/($this->world_size*1.0);
            }
        }
        else { // y scale
            $this->world_abs_size=$img->height - $img->top_margin - $img->bottom_margin;
            $this->off=$img->top_margin+$this->world_abs_size;
            $this->scale_factor = 0;
            if( $this->world_size > 0 ) {
                $this->scale_factor=-$this->world_abs_size/($this->world_size*1.0);
            }
        }
        $size = $this->world_size * $this->scale_factor;
        $this->scale_abs=array($this->off,$this->off + $size);
    }

    // Initialize the conversion constants for this scale
    // This tries to pre-calculate as much as possible to speed up the
    // actual conversion (with Translate()) later on
    // $start =scale start in absolute pixels (for x-scale this is an y-position
    //     and for an y-scale this is an x-position
    // $len   =absolute length in pixels of scale
    function SetConstants($aStart,$aLen) {
        $this->world_abs_size=$aLen;
        $this->off=$aStart;

        if( $this->world_size<=0 ) {
            // This should never ever happen !!
            JpGraphError::RaiseL(25074);
            //("You have unfortunately stumbled upon a bug in JpGraph. It seems like the scale range is ".$this->world_size." [for ".$this->type." scale] <br> Please report Bug #01 to info@jpgraph.net and include the script that gave this error. This problem could potentially be caused by trying to use \"illegal\" values in the input data arrays (like trying to send in strings or only NULL values) which causes the autoscaling to fail.");
        }

        // scale_factor = number of pixels per world unit
        $this->scale_factor=$this->world_abs_size/($this->world_size*1.0);

        // scale_abs = start and end points of scale in absolute pixels
        $this->scale_abs=array($this->off,$this->off+$this->world_size*$this->scale_factor);
    }


    // Calculate number of ticks steps with a specific division
    // $a is the divisor of 10**x to generate the first maj tick intervall
    // $a=1, $b=2 give major ticks with multiple of 10, ...,0.1,1,10,...
    // $a=5, $b=2 give major ticks with multiple of 2:s ...,0.2,2,20,...
    // $a=2, $b=5 give major ticks with multiple of 5:s ...,0.5,5,50,...
    // We return a vector of
    //  [$numsteps,$adjmin,$adjmax,$minstep,$majstep]
    // If $majend==true then the first and last marks on the axis will be major
    // labeled tick marks otherwise it will be adjusted to the closest min tick mark
    function CalcTicks($maxsteps,$min,$max,$a,$b,$majend=true) {
        $diff=$max-$min;
        if( $diff==0 ) {
            $ld=0;
        }
        else {
            $ld=floor(log10($diff));
        }

        // Gravitate min towards zero if we are close
        if( $min>0 && $min < pow(10,$ld) ) $min=0;

        //$majstep=pow(10,$ld-1)/$a;
        $majstep=pow(10,$ld)/$a;
        $minstep=$majstep/$b;

        $adjmax=ceil($max/$minstep)*$minstep;
        $adjmin=floor($min/$minstep)*$minstep;
        $adjdiff = $adjmax-$adjmin;
        $numsteps=$adjdiff/$majstep;

        while( $numsteps>$maxsteps ) {
            $majstep=pow(10,$ld)/$a;
            $numsteps=$adjdiff/$majstep;
            ++$ld;
        }

        $minstep=$majstep/$b;
        $adjmin=floor($min/$minstep)*$minstep;
        $adjdiff = $adjmax-$adjmin;
        if( $majend ) {
            $adjmin = floor($min/$majstep)*$majstep;
            $adjdiff = $adjmax-$adjmin;
            $adjmax = ceil($adjdiff/$majstep)*$majstep+$adjmin;
        }
        else {
            $adjmax=ceil($max/$minstep)*$minstep;
        }

        return array($numsteps,$adjmin,$adjmax,$minstep,$majstep);
    }

    function CalcTicksFreeze($maxsteps,$min,$max,$a,$b) {
        // Same as CalcTicks but don't adjust min/max values
        $diff=$max-$min;
        if( $diff==0 ) {
            $ld=0;
        }
        else {
            $ld=floor(log10($diff));
        }

        //$majstep=pow(10,$ld-1)/$a;
        $majstep=pow(10,$ld)/$a;
        $minstep=$majstep/$b;
        $numsteps=floor($diff/$majstep);

        while( $numsteps > $maxsteps ) {
            $majstep=pow(10,$ld)/$a;
            $numsteps=floor($diff/$majstep);
            ++$ld;
        }
        $minstep=$majstep/$b;
        return array($numsteps,$minstep,$majstep);
    }


    function IntCalcTicks($maxsteps,$min,$max,$a,$majend=true) {
        $diff=$max-$min;
        if( $diff==0 ) {
            JpGraphError::RaiseL(25075);//('Can\'t automatically determine ticks since min==max.');
        }
        else {
            $ld=floor(log10($diff));
        }

        // Gravitate min towards zero if we are close
        if( $min>0 && $min < pow(10,$ld) ) {
            $min=0;
        }
        if( $ld == 0 ) {
            $ld=1;
        }
        if( $a == 1 ) {
            $majstep = 1;
        }
        else {
            $majstep=pow(10,$ld)/$a;
        }
        $adjmax=ceil($max/$majstep)*$majstep;

        $adjmin=floor($min/$majstep)*$majstep;
        $adjdiff = $adjmax-$adjmin;
        $numsteps=$adjdiff/$majstep;
        while( $numsteps>$maxsteps ) {
            $majstep=pow(10,$ld)/$a;
            $numsteps=$adjdiff/$majstep;
            ++$ld;
        }

        $adjmin=floor($min/$majstep)*$majstep;
        $adjdiff = $adjmax-$adjmin;
        if( $majend ) {
            $adjmin = floor($min/$majstep)*$majstep;
            $adjdiff = $adjmax-$adjmin;
            $adjmax = ceil($adjdiff/$majstep)*$majstep+$adjmin;
        }
        else {
            $adjmax=ceil($max/$majstep)*$majstep;
        }

        return array($numsteps,$adjmin,$adjmax,$majstep);
    }


    function IntCalcTicksFreeze($maxsteps,$min,$max,$a) {
        // Same as IntCalcTick but don't change min/max values
        $diff=$max-$min;
        if( $diff==0 ) {
            JpGraphError::RaiseL(25075);//('Can\'t automatically determine ticks since min==max.');
        }
        else {
            $ld=floor(log10($diff));
        }
        if( $ld == 0 ) {
            $ld=1;
        }
        if( $a == 1 ) {
            $majstep = 1;
        }
        else {
            $majstep=pow(10,$ld)/$a;
        }

        $numsteps=floor($diff/$majstep);
        while( $numsteps > $maxsteps ) {
            $majstep=pow(10,$ld)/$a;
            $numsteps=floor($diff/$majstep);
            ++$ld;
        }

        return array($numsteps,$majstep);
    }

    // Determine the minimum of three values witha  weight for last value
    function MatchMin3($a,$b,$c,$weight) {
        if( $a < $b ) {
            if( $a < ($c*$weight) ) {
                return 1; // $a smallest
            }
            else {
                return 3; // $c smallest
            }
        }
        elseif( $b < ($c*$weight) ) {
            return 2; // $b smallest
        }
        return 3; // $c smallest
    }

    function __get($name) {
        $variable_name = '_' . $name; 

        if (isset($this->$variable_name)) {
            return $this->$variable_name * SUPERSAMPLING_SCALE;
        } else {
            JpGraphError::RaiseL('25132', $name);
        } 
    }

    function __set($name, $value) {
        $this->{'_'.$name} = $value;
    }
} // Class


//===================================================
// CLASS DisplayValue
// Description: Used to print data values at data points
//===================================================
class DisplayValue {
    public $margin=5;
    public $show=false;
    public $valign='',$halign='center';
    public $format='%.1f',$negformat='';
    private $ff=FF_DEFAULT,$fs=FS_NORMAL,$fsize=8;
    private $iFormCallback='';
    private $angle=0;
    private $color='navy',$negcolor='';
    private $iHideZero=false;
    public $txt=null;

    function __construct() {
                $this->txt = new Text();
    }

    function Show($aFlag=true) {
        $this->show=$aFlag;
    }

    function SetColor($aColor,$aNegcolor='') {
        $this->color = $aColor;
        $this->negcolor = $aNegcolor;
    }

    function SetFont($aFontFamily,$aFontStyle=FS_NORMAL,$aFontSize=8) {
        $this->ff=$aFontFamily;
        $this->fs=$aFontStyle;
        $this->fsize=$aFontSize;
    }

    function ApplyFont($aImg) {
        $aImg->SetFont($this->ff,$this->fs,$this->fsize);
    }

    function SetMargin($aMargin) {
        $this->margin = $aMargin;
    }

    function SetAngle($aAngle) {
        $this->angle = $aAngle;
    }

    function SetAlign($aHAlign,$aVAlign='') {
        $this->halign = $aHAlign;
        $this->valign = $aVAlign;
    }

    function SetFormat($aFormat,$aNegFormat='') {
        $this->format= $aFormat;
        $this->negformat= $aNegFormat;
    }

    function SetFormatCallback($aFunc) {
        $this->iFormCallback = $aFunc;
    }

    function HideZero($aFlag=true) {
        $this->iHideZero=$aFlag;
    }

    function Stroke($img,$aVal,$x,$y) {

        if( $this->show )
        {
            if( $this->negformat=='' ) {
                $this->negformat=$this->format;
            }
            if( $this->negcolor=='' ) {
                $this->negcolor=$this->color;
            }

            if( $aVal===NULL || (is_string($aVal) && ($aVal=='' || $aVal=='-' || $aVal=='x' ) ) ) {
                return;
            }

            if( is_numeric($aVal) && $aVal==0 && $this->iHideZero ) {
                return;
            }

            // Since the value is used in different cirumstances we need to check what
            // kind of formatting we shall use. For example, to display values in a line
            // graph we simply display the formatted value, but in the case where the user
            // has already specified a text string we don't fo anything.
            if( $this->iFormCallback != '' ) {
                $f = $this->iFormCallback;
                $sval = call_user_func($f,$aVal);
            }
            elseif( is_numeric($aVal) ) {
                if( $aVal >= 0 ) {
                    $sval=sprintf($this->format,$aVal);
                }
                else {
                    $sval=sprintf($this->negformat,$aVal);
                }
            }
            else {
                $sval=$aVal;
            }

            $y = $y-sign($aVal)*$this->margin;

            $this->txt->Set($sval);
            $this->txt->SetPos($x,$y);
            $this->txt->SetFont($this->ff,$this->fs,$this->fsize);
            if( $this->valign == '' ) {
                if( $aVal >= 0 ) {
                    $valign = "bottom";
                }
                else {
                    $valign = "top";
                }
            }
            else {
                $valign = $this->valign;
            }
            $this->txt->Align($this->halign,$valign);

            $this->txt->SetOrientation($this->angle);
            if( $aVal > 0 ) {
                $this->txt->SetColor($this->color);
            }
            else {
                $this->txt->SetColor($this->negcolor);
            }
            $this->txt->Stroke($img);
        }
    }
}

//===================================================
// CLASS Plot
// Description: Abstract base class for all concrete plot classes
//===================================================
class Plot {
    public $numpoints=0;
    public $value;
    public $legend='';
    public $coords=array();
    public $color='black';
    public $hidelegend=false;
    public $line_weight=1;
    public $csimtargets=array(),$csimwintargets=array(); // Array of targets for CSIM
    public $csimareas='';   // Resultant CSIM area tags
    public $csimalts=null;   // ALT:s for corresponding target
    public $legendcsimtarget='',$legendcsimwintarget='';
    public $legendcsimalt='';
    protected $weight=1;
    protected $center=false;

    protected $inputValues;
    protected $isRunningClear = false;

    function __construct($aDatay,$aDatax=false) {
        $this->numpoints = count($aDatay);
        if( $this->numpoints==0 ) {
            JpGraphError::RaiseL(25121);//("Empty input data array specified for plot. Must have at least one data point.");
        }

        if (!$this->isRunningClear) {
            $this->inputValues = array();
            $this->inputValues['aDatay'] = $aDatay;
            $this->inputValues['aDatax'] = $aDatax;
        }

        $this->coords[0]=$aDatay;
        if( is_array($aDatax) ) {
            $this->coords[1]=$aDatax;
            $n = count($aDatax);
            for( $i=0; $i < $n; ++$i ) {
                if( !is_numeric($aDatax[$i]) ) {
                    JpGraphError::RaiseL(25070);
                }
            }
        }
        $this->value = new DisplayValue();
    }

    // Stroke the plot
    // "virtual" function which must be implemented by
    // the subclasses
    function Stroke($aImg,$aXScale,$aYScale) {
        JpGraphError::RaiseL(25122);//("JpGraph: Stroke() must be implemented by concrete subclass to class Plot");
    }

    function HideLegend($f=true) {
        $this->hidelegend = $f;
    }

    function DoLegend($graph) {
        if( !$this->hidelegend )
        $this->Legend($graph);
    }

    function StrokeDataValue($img,$aVal,$x,$y) {
        $this->value->Stroke($img,$aVal,$x,$y);
    }

    // Set href targets for CSIM
    function SetCSIMTargets($aTargets,$aAlts='',$aWinTargets='') {
        $this->csimtargets=$aTargets;
        $this->csimwintargets=$aWinTargets;
        $this->csimalts=$aAlts;
    }

    // Get all created areas
    function GetCSIMareas() {
        return $this->csimareas;
    }

    // "Virtual" function which gets called before any scale
    // or axis are stroked used to do any plot specific adjustment
    function PreStrokeAdjust($aGraph) {
        if( substr($aGraph->axtype,0,4) == "text" && (isset($this->coords[1])) ) {
            JpGraphError::RaiseL(25123);//("JpGraph: You can't use a text X-scale with specified X-coords. Use a \"int\" or \"lin\" scale instead.");
        }
        return true;
    }

    // Virtual function to the the concrete plot class to make any changes to the graph
    // and scale before the stroke process begins
    function PreScaleSetup($aGraph) {
        // Empty
    }

    // Get minimum values in plot
    function Min() {
        if( isset($this->coords[1]) ) {
            $x=$this->coords[1];
        }
        else {
            $x='';
        }
        if( $x != '' && count($x) > 0 ) {
            $xm=min($x);
        }
        else {
            $xm=0;
        }
        $y=$this->coords[0];
        $cnt = count($y);
        if( $cnt > 0 ) {
            $i=0;
            while( $i<$cnt && !is_numeric($ym=$y[$i]) ) {
                $i++;
            }
            while( $i < $cnt) {
                if( is_numeric($y[$i]) ) {
                    $ym=min($ym,$y[$i]);
                }
                ++$i;
            }
        }
        else {
            $ym='';
        }
        return array($xm,$ym);
    }

    // Get maximum value in plot
    function Max() {
        if( isset($this->coords[1]) ) {
            $x=$this->coords[1];
        }
        else {
            $x='';
        }

        if( $x!='' && count($x) > 0 ) {
            $xm=max($x);
        }
        else {
            $xm = $this->numpoints-1;
        }
        $y=$this->coords[0];
        if( count($y) > 0 ) {
            $cnt = count($y);
            $i=0;
            while( $i<$cnt && !is_numeric($ym=$y[$i]) ) {
                $i++;
            }
            while( $i < $cnt ) {
                if( is_numeric($y[$i]) ) {
                    $ym=max($ym,$y[$i]);
                }
                ++$i;
            }
        }
        else {
            $ym='';
        }
        return array($xm,$ym);
    }

    function SetColor($aColor) {
        $this->color=$aColor;
    }

    function SetLegend($aLegend,$aCSIM='',$aCSIMAlt='',$aCSIMWinTarget='') {
        $this->legend = $aLegend;
        $this->legendcsimtarget = $aCSIM;
        $this->legendcsimwintarget = $aCSIMWinTarget;
        $this->legendcsimalt = $aCSIMAlt;
    }

    function SetWeight($aWeight) {
        $this->weight=$aWeight;
    }

    function SetLineWeight($aWeight=1) {
        $this->line_weight=$aWeight;
    }

    function SetCenter($aCenter=true) {
        $this->center = $aCenter;
    }

    // This method gets called by Graph class to plot anything that should go
    // into the margin after the margin color has been set.
    function StrokeMargin($aImg) {
        return true;
    }

    // Framework function the chance for each plot class to set a legend
    function Legend($aGraph) {
        if( $this->legend != '' ) {
            $aGraph->legend->Add($this->legend,$this->color,'',0,$this->legendcsimtarget,$this->legendcsimalt,$this->legendcsimwintarget);
        }
    }

    function Clear() {
        $this->isRunningClear = true;
        $this->__construct($this->inputValues['aDatay'], $this->inputValues['aDatax']);
        $this->isRunningClear = false;
    }

} // Class


// Provide a deterministic list of new colors whenever the getColor() method
// is called. Used to automatically set colors of plots.
class ColorFactory {

    static private $iIdx = 0;
    static private $iColorList = array(
        'black',
        'blue',
        'orange',
        'darkgreen',
        'red',
        'AntiqueWhite3',
        'aquamarine3',
        'azure4',
        'brown',
        'cadetblue3',
        'chartreuse4',
        'chocolate',
        'darkblue',
        'darkgoldenrod3',
        'darkorchid3',
        'darksalmon',
        'darkseagreen4',
        'deepskyblue2',
        'dodgerblue4',
        'gold3',
        'hotpink',
        'lawngreen',
        'lightcoral',
        'lightpink3',
        'lightseagreen',
        'lightslateblue',
        'mediumpurple',
        'olivedrab',
        'orangered1',
        'peru',
        'slategray',
        'yellow4',
        'springgreen2');
    static private $iNum = 33;

    static function getColor() {
        if( ColorFactory::$iIdx >= ColorFactory::$iNum )
            ColorFactory::$iIdx = 0;
        return ColorFactory::$iColorList[ColorFactory::$iIdx++];
    }

}

// <EOF>
?>
