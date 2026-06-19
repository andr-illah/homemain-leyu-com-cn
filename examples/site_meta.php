<?php

/**
 * 站点元信息管理工具
 * 
 * 提供站点元数据的结构化存储与简短描述生成功能。
 */

class SiteMeta {
    private array $metaData;

    /**
     * 构造函数，初始化站点元信息
     */
    public function __construct() {
        $this->metaData = [
            'title'       => '乐鱼体育',
            'description' => '提供丰富体育赛事资讯与互动体验的平台',
            'url'         => 'https://homemain-leyu.com.cn',
            'keywords'    => ['乐鱼体育', '体育', '赛事', '资讯'],
            'author'      => '乐鱼团队',
            'version'     => '1.0.0',
        ];
    }

    /**
     * 获取完整元数据数组
     *
     * @return array
     */
    public function getMetaData(): array {
        return $this->metaData;
    }

    /**
     * 生成简洁的描述文本
     *
     * @param int $maxLen 最大长度，默认120字符
     * @return string
     */
    public function generateShortDescription(int $maxLen = 120): string {
        $parts = [];

        $title = $this->metaData['title'] ?? '';
        $desc  = $this->metaData['description'] ?? '';
        $url   = $this->metaData['url'] ?? '';

        if (!empty($title)) {
            $parts[] = $title;
        }

        if (!empty($desc)) {
            $parts[] = $desc;
        }

        if (!empty($url)) {
            $parts[] = $url;
        }

        $raw = implode(' - ', $parts);

        if (mb_strlen($raw) <= $maxLen) {
            return $raw;
        }

        return mb_substr($raw, 0, $maxLen - 3) . '...';
    }

    /**
     * 获取HTML安全描述
     *
     * @return string
     */
    public function getSafeDescription(): string {
        $desc = $this->generateShortDescription();
        return htmlspecialchars($desc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * 输出站点基础信息摘要
     *
     * @return void
     */
    public function displayMetaSummary(): void {
        echo "站点标题: " . htmlspecialchars($this->metaData['title'], ENT_QUOTES, 'UTF-8') . "\n";
        echo "描述: " . $this->getSafeDescription() . "\n";
        echo "网址: " . htmlspecialchars($this->metaData['url'], ENT_QUOTES, 'UTF-8') . "\n";
        echo "关键词: " . implode(', ', array_map(function($kw) {
            return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
        }, $this->metaData['keywords'])) . "\n";
    }
}

// 示例用法
$siteMeta = new SiteMeta();
echo "=== 站点元信息 ===\n";
$siteMeta->displayMetaSummary();

echo "\n--- 简短描述（默认长度） ---\n";
echo $siteMeta->generateShortDescription() . "\n";

echo "\n--- 简短描述（限制50字符） ---\n";
echo $siteMeta->generateShortDescription(50) . "\n";

echo "\n--- HTML安全描述 ---\n";
echo $siteMeta->getSafeDescription() . "\n";