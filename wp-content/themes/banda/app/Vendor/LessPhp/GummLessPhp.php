<?php
class GummLessPhp {
    
    public $matchAgainst = array(
        '@bluebox-color-option',
        '@bluebox-bg-option',
        '@bluebox-text-option',
    );
    
    protected $lines        = array();
    protected $outputLines  = array();
    protected $output       = '';
    
    private $string = '';
    private $currentBlockType = 'none';
    private $env = array();
    private $currentIndex;
    private $whiteSpaceChars = array(' ');
    
    private $blocks = array();
    private $currentBlock = array();
    
    private $contextLevel   = 0;
    private $blockContext   = 'none';
    
    public function compileFile($filename) {
        $this->compile(file_get_contents($filename));
    }
    
    public function compile($string) {
        $this->string = $string;
        
        $strlen = strlen($string);
        for ($i=0; $i<$strlen; $i++) {
            $char = $string[$i];
            
            if ($char === '{') {
                $blockName = $this->getBlockNameFromPosition($i);
                
                $this->blockContext = $blockName;
                // 
                // $block = array(
                //     'selector' => $blockName,
                //     'properties' => array(),
                //     'children' => array(),
                // );
                // if ($this->contextLevel > 0) {
                //     $this->currentBlock['children'][] = $block;
                // }
                // 
                // if ($this->contextLevel === 0) {
                //     $this->blocks[] &= $this->currentBlock;
                // }
                
                $this->currentBlock = $this->pushBlock($blockName);
                
                $this->contextLevel++;
            } elseif ($char === '}') {
                $this->contextLevel--;
                
            } elseif ($this->blockContext !== 'none') {
                
            }
            
        }
        
        // d($this->blocks);
    }
    
    private function pushBlock($blockName, &$blocks=null) {
        if ($blocks === null) {
            $blocks =& $this->blocks;
        }
        $newBlock = array(
            'selector' => $blockName,
            'properties' => array(),
            'children' => array(),
        );
        
        if ($this->contextLevel === 0) {
            $blocks[] = $newBlock;
        }
        // elseif ($blocks) {
        //     $endRootBlock =& $blocks[count($blocks) - 1];
        //     
        //     
        //     $this->pushBlock($blockName, $endRootBlock['children']);
        // } elseif ($blocks !== null) {
        //     // d($blocks);
        //     $blocks = $newBlock;
        // }
    }
    
    public function compiles($string) {
        $this->string =& $string;
        
        $output = '';
        $strlen = strlen($string);
        for ($i=0; $i<$strlen; $i++) {
            $char = $string[$i];
            if (in_array($char, $this->whiteSpaceChars)) {
                continue;
            }
            
            if ($char === '{') {

                if ($this->currentBlock) {
                    d($this->currentBlock);
                }
                $this->currentBlock = array(
                    'name' => $this->getBlockNameFromPosition($i),
                    'declarations' => array(),
                );
            } elseif ($char === '}') {
                $this->currentBlock = array();
            } elseif ($this->currentBlock) {
                echo $char;
                // $this->currentBlock['declarations'] .= $char;
            }
            
            // $output .= $char;
        }
        
        d($output);
        
        // $this->lines = $lines = explode("\n", $string);
        // $linesCount = count($lines);
        // 
        // for ($i=0; $i<$linesCount; $i++) {
        //     $this->currentIndex = $i;
        //     $this->proccessLine($lines[$i]);
        // }
        // for ($i=0; $i<$linesCount; $i++) {
        //     $line = rtrim($lines[$i]);
        //     $cleanLine = trim($line);
        // 
        //     // if the line is comment - continue
        //     if (preg_match("/^\/\*.*\*\/$/", $cleanLine)) {
        //         continue;
        //     }
        //     if (strpos($cleanLine, '//') === 0) {
        //         continue;
        //     }
        //     if (strpos($cleanLine, '/*') === 0) {
        //         $this->currentBlockType = 'comment';
        //         continue;
        //     }
        //     if (strpos($cleanLine, '*/') === (strlen($cleanLine)-2)) {
        //         $this->currentBlockType = 'none';
        //         continue;
        //     }
        //     if ($this->currentBlockType === 'comment') {
        //         continue;
        //     }
        // 
        //     if (strpos($cleanLine, '{') === (strlen($cleanLine)-1)) {
        //         $this->currentBlockType = 'block';
        // 
        //         $this->outputLines[] = $line;
        //         continue;
        //     }
        //     if (strpos($cleanLine, '}') === 0) {
        //         $this->outputLines[] = $line;
        //         continue;
        //     }
        //     
        // }
        
        $this->parseProccessedLines();
        
        d($this->output);
    }
    
    private function getBlockNameFromPosition($i) {
        $blockName = '';
        for ($n=$i-1; $n>=0; $n--) {
            $rchar = $this->string[$n];
            if ($rchar === "}" || $rchar === ';') {
                if (!$blockName) {
                    continue;
                } else {
                    break;
                }
            }
            $blockName .= $this->string[$n];
        }
        $blockName = $this->cleanupComments(trim(strrev($blockName)));
        
        return $blockName;
    }
    
    private function isPositionComment($i) {
        
    }
    
    private function cleanupComments($string) {
        $lines = explode("\n", $string);
        
        $output = '';
        $inCommentBlock = false;
        foreach ($lines as $line) {
            $line = rtrim($line);
            $cleanLine = trim($line);
            if (!$cleanLine) {
                continue;
            }
            if (preg_match("/^\/\*.*\*\/$/", $cleanLine)) {
                continue;
            }
            if (strpos($cleanLine, '//') === 0) {
                continue;
            }
            if (strpos($cleanLine, '/*') === 0) {
                $inCommentBlock = true;
                continue;
            }
            if (strpos($cleanLine, '*/') === (strlen($cleanLine)-2)) {
                $inCommentBlock = false;
                continue;
            }
            if (!$inCommentBlock) {
                $output .= $line;
            }
        }
        return $output;
    }
    
    private function proccessLine($line) {
        $line = rtrim($line);
        $cleanLine = trim($line);
        
        // if the line is comment - return
        if (preg_match("/^\/\*.*\*\/$/", $cleanLine)) {
            return;
        }
        if (strpos($cleanLine, '//') === 0) {
            return;
        }
        if (strpos($cleanLine, '/*') === 0) {
            $this->currentBlockType = 'comment';
            return;
        }
        if (strpos($cleanLine, '*/') === (strlen($cleanLine)-2)) {
            $this->currentBlockType = 'none';
            return;
        }
        if ($this->currentBlockType === 'comment') {
            return;
        }
        
        if (strpos($cleanLine, '{') === (strlen($cleanLine)-1)) {
            $this->currentBlockType = 'block';
            
            $this->outputLines[] = $line;
            return;
        }
        if (strpos($cleanLine, '}') === 0) {
            $this->outputLines[] = $line;
            return;
        }
        
        foreach ($this->matchAgainst as $matchAgainst) {
            if (strpos($cleanLine, $matchAgainst) !== false) {
                $this->outputLines[] = $line;
                break;
            }
        }
    }
    
    private function parseProccessedLines() {
        $length = count($this->outputLines);
        for ($i=0; $i<$length; $i++) {
            $this->output .= $this->outputLines[$i] . "\n";
        }
    }
    
    private function pushEnv($line) {
        $this->env[] = $line;
    }
}
?>