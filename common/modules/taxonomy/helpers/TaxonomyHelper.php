<?php

namespace common\modules\taxonomy\helpers;

use yii;
use yii\db\ActiveRecordInterface;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;
use common\modules\taxonomy\models\TaxonomyItems;

class TaxonomyHelper
{


    /**
     * @param TaxonomyItems $term
     * @return string
     */
    public static function t(TaxonomyItems $term)
    {
        return $term->data['translations'][Yii::$app->language] ?? $term->name;
    }

    /**
     * @param array $terms
     * @param array $excludedIds
     * @return array
     */
    public static function toArray(array $terms, array $excludedIds = [])
    {

        $terms = array_filter($terms, function ($item) use ($excludedIds) {
            return !in_array($item->id, $excludedIds);
        });

        $terms = array_values($terms);

        return ArrayHelper::toArray($terms, [
            TaxonomyItems::class => [
                'id',
                'vid',
                'pid',
                'name',
                'weight',
                'childrens',
                'vocabulary'
            ]
        ]);

    }

    /**
     * @param array $terms
     * @param int|null $parent
     * @param null $depth
     * @return array
     */
    public static function tree(array $terms, int $parent = null, $depth = NULL)
    {

        $tree = self::treeMap($terms);

        if ($parent)
            $tree = self::treeParent($tree, $parent);
        if ($depth !== NULL)
            $tree = self::treeDepth($tree, $depth);

        return $tree;
    }

    /**
     *
     * @param array $terms
     * @return []
     */
    public static function order(array $terms)
    {
        $tree = self::treeMap($terms);
        return array_reverse(self::tree2Flat(reset($tree)));
    }

    /**
     *
     * @param TaxonomyItems $tree
     * @param array $terms
     * @return TaxonomyItems
     */
    private static function tree2Flat(TaxonomyItems $tree, &$terms = [])
    {
        if (!empty($tree->childrens)) {
            foreach ($tree->childrens as $children) {
                self::tree2Flat($children, $terms);
            }
        }
        $tree->childrens = [];
        $terms[] = $tree;
        return $terms;
    }

    /**
     *
     * @param array $dataset
     * @param string $childKey
     * @return array
     */
    private static function treeMap(array $dataset, $childKey = 'children')
    {
        $dataset = ArrayHelper::index($dataset, 'id');

        $tree = [];
        foreach ($dataset as $id => &$node) {
            if (isset($node->pid)) {
                if (!$node->pid) {
                    $node->pid = 0;
                    $tree[$node->id] = &$node;
                } else {
                    $dataset[$node->pid]->childrens[] = &$node;
                }
            }
        }
        return $tree;
    }

    /**
     *
     * @param array $tree
     * @param int $maxDepth
     * @param int $curDepth
     * @return array
     */
    private function treeDepth(array $tree, $maxDepth, $curDepth = 0)
    {
        foreach ($tree as $index => $item) {
            if (!empty($item->childrens) && $curDepth + 1 > $maxDepth) {
                $item->childrens = [];
            } elseif (!empty($item->childrens)) {
                $item->childrens = self::treeDepth($item->childrens, $maxDepth, $curDepth + 1);
            }
            $tree[$index] = $item;
        }
        return $tree;
    }

    /**
     *
     * @param array $tree
     * @param int $parent
     * @return array
     */
    private function treeParent(array $tree, $parent)
    {

        if (!$parent) {
            return $tree;
        }

        foreach ($tree as $index => $item) {
            if ($item->id == $parent) {
                return [$index => $item];
            } elseif (isset($item->childrens)) {
                $tree = self::treeParent($item->childrens, $parent);
            }

        }
        return $tree;
    }

    /**
     * @param TaxonomyItems $tree
     * @return int
     */
    public static function countChildren(TaxonomyItems $tree)
    {
        $count = count($tree->childrens);
        if ($count) {
            foreach ($tree->childrens as $children) {
                $count += self::countChildren($children);
            }
        }

        return $count;
    }

    /**
     *
     * @param TaxonomyItems $term
     * @return TaxonomyItems
     */
    public static function lastChildren(TaxonomyItems $term)
    {

        if (empty($term->childrens)) {
            return $term;
        }

        foreach ($term->childrens as $children) {
            return self::lastChildren($children);
        }
    }

    /**
     * @param $tree
     * @param int $parent
     * @param int $weight
     * @return array
     */
    public static function nes2Flat($tree, $parent = 0, $weight = 0)
    {
        $d = [];
        $t = [];

        if (!is_array($tree)) {
            return [];
        }
        foreach ($tree as $key => $item) {
            $additionalFields = $item;
            if (!isset($item['children'])) {
                $weight++;
                $d[$item['id']] = array_merge(['pid' => $parent, 'weight' => $weight], $additionalFields);
            } else {
                unset($additionalFields['children']);
                $weight++;
                $d[$item['id']] = array_merge(['pid' => $parent, 'weight' => $weight], $additionalFields);
                $t = self::nes2Flat($item['children'], $item['id'], $weight);
                $d += $t;
            }
            $weight++;
        }
        return $d;
    }

    /**
     * @param ActiveRecordInterface $model
     * @return array
     */
    public static function getTermAttributes(ActiveRecordInterface $model)
    {
        $fields = [];
        $rules = $model->rules();
        foreach ($rules as $rule) {
            $field = array_shift($rule);
            $type = current($rule);
            if ($type == TaxonomyAttributeValidator::class) {
                $fieldsTmp = [];
                if (is_array($field)) {
                    $fieldsTmp = $field;
                } else {
                    $fieldsTmp[] = $field;
                }

                foreach ($fieldsTmp as $field) {
                    $fields[$field] = array_merge([$field], $rule);
                }
            }
        }
        return $fields;
    }

    /**
     * @param array $terms
     * @return string
     */
    public static function terms2IndexedArray(array $terms)
    {
        if (!is_array($terms) || !(current($terms) instanceof TaxonomyItems)) {
            return json_encode([]);
        }
        $terms = ArrayHelper::getColumn($terms, function ($element) {
            return [
                'id' => $element->id,
                'name' => $element->name . ':' . $element->vocabulary->name
            ];
        });

        return json_encode(ArrayHelper::map($terms, 'id', 'name'));
    }

}
