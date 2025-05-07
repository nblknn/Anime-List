<?php

declare (strict_types = 1);

class TemplateEngine {
    private const string TEMP_FILE = 'temp.php';
    private const string TEMPLATE_DIR = __DIR__ . "/view/templates/";
    private const string ADMIN_TEMPLATE_DIR = __DIR__ . "/view/admin/templates/";

    public function render(string $template, array $data): string {
        $file = file_get_contents($template);
        $file = preg_replace_callback('/\{\{tpl\s+(.*)}}/', function($matches) {
            if (str_starts_with($matches[1], 'admin'))
                return file_get_contents(self::ADMIN_TEMPLATE_DIR . lcfirst(substr($matches[1], 5)) . '.tpl');
            return file_get_contents(self::TEMPLATE_DIR . $matches[1] . '.tpl');
        }, $file);
        $file = preg_replace('/\{\{foreach\s*\((\$.*?)\)\s*}}/',  '<?php foreach ($1):?>', $file);
        $file = preg_replace('/\{\{endforeach}}/', '<?php endforeach; ?>', $file);
        $file = preg_replace('/\{\{if\s*\((.*?)\)\s*}}/', '<?php if ($1): ?>', $file);
        $file = preg_replace('/\{\{else}}/', '<?php else: ?>', $file);
        $file = preg_replace('/\{\{endif}}/', '<?php endif; ?>', $file);
        $file = preg_replace('/\{\{echo\s*(.*?)\s*}}/','<?php echo $1;?>',$file);
        return $this->executePhpCode($file, $data);
    }

    private function executePhpCode(string $phpCode, array $data): string {
        file_put_contents(self::TEMP_FILE, $phpCode);
        extract($data);
        ob_start();
        include self::TEMP_FILE;
        $result = ob_get_clean();
        unlink(self::TEMP_FILE);
        return $result;
    }
}