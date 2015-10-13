<?php

    if (!isset($argv)) {
        exit;
    }

    list($file, $type) = parseArgv($argv);

    clearFolder();

    $text = file_get_contents($file);    
    $lines = explode("----\n", $text);
    $files = [];
    $index = 0;
    foreach ($lines as $line) {
        $index++;
        buildStaticGif($index, $line);
    }
    $totalPage = $index;

    buildDynamicGif($totalPage);
    exit;




    /**
     *  逐次建立每一頁內容
     */
    function buildStaticGif($index, $content)
    {
        $dir = __DIR__;
        $number = sprintf("%02d", $index);
        $pageFile =  "{$dir}/tmp/{$number}.txt";
        
        // build text
        file_put_contents($pageFile, $content);

        // build static gif
        exec("cat {$pageFile} | convert -size 700x300 -pointsize 16 -font {$dir}/fonts/DroidSansMono.ttf -fill white -background black -border 10x10 -bordercolor black label:@- $dir/tmp/{$number}.gif");
    }

    /**
     *  將每一頁內容串成一個 動態的 gif
     */
    function buildDynamicGif($totalPage)
    {
        $dir = __DIR__;
        exec("convert -delay 100 -loop 0 {$dir}/tmp/*.gif {$dir}/output/output.gif");
    }

    /**
     *  TODO: type 功能未撰寫
     */
    function parseArgv($argv)
    {
        $file = isset($argv[1]) ? $argv[1] : null;
        $type = isset($argv[2]) ? $argv[2] : 'default-type';
        validate($file, $type);

        return [$file, $type];
    }

    /**
     *
     */
    function validate($file, $type)
    {
        if (PHP_SAPI !== 'cli') {
            exit;
        }

        if (!isset($file)) {
            echo "Text file not input\n";
            exit;
        }

        if (!file_exists($file)) {
            echo "Text file not found\n";
            exit;
        }
    }

    /**
     *
     */
    function clearFolder()
    {
        $dir = __DIR__;
        foreach (glob("{$dir}/tmp/*.txt") as $file) {
            unlink($file);
        }
        foreach (glob("{$dir}/tmp/*.gif") as $file) {
            unlink($file);
        }
    }
