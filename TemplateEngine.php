<?php

class TemplateEngine {
    public function render($template, $data) {
        $file = file_get_contents($template);
        $file = preg_replace('/\{\{foreach\s*\((\$.*)\)\s*}}/',
            '<?php foreach ($1):?>', $file);
        $file = preg_replace('/\{\{endforeach}}/', '<?php endforeach; ?>', $file);
        $file = preg_replace('/\{\{if\s*\((\$.*)\)\s*}}/', '<?php if ($1): ?>', $file);
        $file = preg_replace('/\{\{endif}}/', '<?php endif; ?>', $file);
        $file = preg_replace('/\{\{echo\s*(.*)\s*}}/','<?php echo $1;?>',$file);
        return $this->executePhpCode($file, $data);
    }

    private function executePhpCode($phpCode, $data) {
        $tempFile = 'temp.php';
        file_put_contents($tempFile, $phpCode);
        extract($data);
        ob_start();
        include $tempFile;
        $result = ob_get_clean();
        unlink($tempFile);
        return $result;
    }
}