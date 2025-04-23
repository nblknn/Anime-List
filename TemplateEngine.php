<?php

declare (strict_types = 1);

class TemplateEngine {
    private const string TEMP_FILE = 'temp.php';
    private array $templates = ["header" => __DIR__ . "/view/templates/header.tpl",
        "footer" => __DIR__ . "/view/templates/footer.tpl",
        "adminHeader" => __DIR__ . "/view/admin/templates/header.tpl",
        "animeList" => __DIR__ . "/view/templates/animeList.tpl",];

    public function render(string $template, array $data): string {
        $file = file_get_contents($template);
        foreach ($this->templates as $key => $value) {
            $file = preg_replace("/\{\{$key}}/", file_get_contents($value), $file);
        }
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