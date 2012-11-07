<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * video.php
 *
 * Requires PHP version 5.0  or more
 *
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@livingstonefultang.com so we can mail you a copy immediately.
 *
 * @author     Livingstone Fultang <livingstone.fultang@gmail.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.2
 * 
 */
class LFT_Toc {

    /**
     * Counts the occurence of header elements in Wordpress content
     * 
     * @param type $content
     * @return null|boolean|array
     */
    static function hasToc($tiers, $content) {

        $pattern = '/<h[2-' . $tiers . ']*[^>]*>(.*?)<\/h([2-' . $tiers . '])>/';
        $return = array();
        if (empty($content))
            return null;

        if (!preg_match_all($pattern, $content, $return)) {
            return false;
        }
        return $return;
    }

    /**
     * Generates a table of content only when singular pages are being viewed
     * 
     * @param int $tiers The number of layers of hx tags to index, i.e h2-h6
     * @param string $content The Post content
     * @param boolean $draw if true will draw the TOC, false will return the toc items
     * @param array $return holds the found htags in the $content if hasToc was previously called
     * @param int $minimal The minimal number of items required for a TOC to be displayed
     * 
     * @return string
     */
    static function generateTableOfContents($tiers, $content, $draw = TRUE, $return = array(), $minimal=3) {

        if (!is_singular())
            return $content;
        
        $toc = '';
        $content = $toc . $content;
        $searches = array();
        $replaces = array();
        $return = (is_array($return) && !empty($return) ) ? $return : LFT_Toc::hasToc($tiers, $content);

        if ($draw && !empty($return)):
            $toc = '<div class="toc pull-left span4">';
            $toc .= "<h4>Table of Contents</h4>";
            $toc .= "<ol class=\"parent start\">";
            $tags = reset($return);
            $titles = $return[1];
            $levels = end($return);
            $_level = 2;
            $chapters = array('0','0','0','0','0','0');
            
            //We will only display a toc if we have more than 3 htags;
            if(sizeof($tags)< $minimal) return $content;

            foreach ($tags as $i => $htag) {
                $attributes = array();
                $href = md5(str_replace(' ', '', $titles[$i]));
                if (preg_match_all("/id=\"([^']*)\"/", $htag, $attributes)) {
                    $oldIds = end($attributes);
                    $href = md5(str_replace(' ', '', $titles[$i]) . reset($oldIds));
                    $newId = 'id="' . $href . '"';
                    $oldId = 'id="' . reset($oldIds) . '"';

                    $htagr = str_replace($oldId, $newId, $htag);
                    $searches[] = $htag;
                    $replaces[] = $htagr;
                } else {
                    $newId = 'id="' . $href . '"';
                    $htagr = str_replace('>' . $titles[$i], "\t" . $newId . '>' . $titles[$i], $htag);
                    $searches[] = $htag;
                    $replaces[] = $htagr;
                }
                if ((int)$levels[$i] === (int)$_level):
                    $chapters[$_level-1] = ((int)$chapters[$_level-1]+1);
                    $chapter = implode('.', array_slice($chapters, 1, ($levels[$i]-1)  ) );
                    $toc .= '<li><span class="toc-chapter">' . strval($chapter) . '</span><a href="#' . $href . '">' . $titles[$i] . '</a></li>';
                endif;

                if ($levels[$i] > $_level) {
                    $_steps = ((int) $levels[$i] - (int) $_level);
                    
                    for ($j = 0; $j < $_steps; $j++):
                        $toc .= '<ol class="continue">';
                        $chapters[$levels[$i]-1+$j] = (int)$chapters[$levels[$i]-1+$j]+1;
                        $_level++;
                    endfor;
                    $chapter = implode('.', array_slice($chapters, 1, ($levels[$i]-1)  ) );
                    $toc .= '<li><span class="toc-chapter">' . strval($chapter) . '</span><a href="#' . $href . '">' . $titles[$i] . '</a></li>';
                }

                if ($levels[$i] < $_level) {
                    
                    $_steps = ((int) $_level - (int) $levels[$i]);
                    $chapters[$levels[$i]-1] = (int)$chapters[$levels[$i]-1]+1;
                    $_olevel = $_level;
                    for ($j = 0; $j < $_steps; $j++):
                        $chapters[$levels[$i]+$j] = 0;
                        $toc .= '</ol>';
                        $_level--;
                    endfor;
                    
                    $chapters[$_olevel-1] = 0;
                    $chapter = implode('.', array_slice($chapters, 1, ($levels[$i]-1)  ) );
                    
                    $toc .= '<li><span class="toc-chapter">' . strval($chapter) . '</span><a href="#' . $href . '">' . $titles[$i] . '</a></li>';
                }
            }
            $toc .= '</ol>';
            $toc .= '</div>';
            $content = str_replace($searches, $replaces, $content);
            $content = $toc . $content;
        endif;

        return $content;
    }

    /**
     * Appends the table of content to the $content
     * AKA. Executes our filter
     * 
     * @param type $content
     * @return type
     */
    static function writeToc($content) {

        $content = LFT_Toc::generateTableOfContents(4, $content, TRUE);
        
        return $content;
    }

}

add_filter('the_content', array('LFT_Toc', 'writeTOC'));

