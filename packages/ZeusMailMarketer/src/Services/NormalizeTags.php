<?php

namespace ZeusMailMarketer\Services;

use \Illuminate\Support\Str as LaravelStr;

class NormalizeTags
{
    public $tags = [];
    public $values = [];
    public $content;

    /**
     * @param string $content
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param string $key
     * @param string|array|boolean|mixed $value
     */
    public function with($key, $value)
    {
        $this->values = collect($this->values)->merge([$key => $value])->toArray();
        return $this;
    }

    public function values($array_of_values)
    {
        $this->values = collect($this->values)->merge($array_of_values)->toArray();
        return $this;
    }
    /**
     * @param array|string $tag
     */
    public function tags($tag)
    {
        if (is_string($tag)) {
            $this->tags = collect($this->tags)->push($tag)->toArray();
            return $this;
        }
        foreach ($tag as $t) {
            $this->tags = collect($this->tags)->push($t)->toArray();
        }
        return $this;
    }

    protected function tag_regex($tag)
    {
        return [
            '/\{\$'. $tag .'\}/',
            '/\{ \$'. $tag .' \}/',
            '/\{ \$'. $tag .'\}/',
            '/\{\$'. $tag .' \}/',
        ];
    }

    protected function replace_values_with_tags()
    {
        $should_replace = collect([]);
        $result = $this->content;
        foreach ($this->tags as $tag) {
            if (isset($this->values[$tag])) {
                foreach ($this->tag_regex($tag) as $regex) {
                    $should_replace->put($regex, $tag);
                }
            }
        }
        foreach ($should_replace as $regex => $tag_name) {
            $result = preg_replace($regex, $this->values[$tag_name], $result);
        }
        return $result;
    }

    /**
     * @return string html
     */
    public function normalize()
    {      
        return (count($this->tags) > 0 && count($this->values) > 0 && strlen($this->content) > 0) 
                ? $this->replace_values_with_tags()
                : 'values not correctly set';
    }
}