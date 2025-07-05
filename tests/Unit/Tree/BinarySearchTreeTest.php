<?php

declare(strict_types=1);

namespace Tests\Unit\Tree;

use PHPUnit\Framework\TestCase;
use Shenlink\Algorithms\Tree\BinarySearchTree;
use Shenlink\Algorithms\Tree\Visitor;

/**
 * 测试二叉搜索树 (BinarySearchTree) 的各项功能
 */
final class BinarySearchTreeTest extends TestCase
{
    /**
     * 被测试的二叉搜索树实例
     */
    private BinarySearchTree $tree;

    /**
     * 在每个测试方法执行前初始化一个空的二叉搜索树
     */
    protected function setUp(): void
    {
        $this->tree = new BinarySearchTree();
    }

    /**
     * 测试 add 方法：验证添加节点后树的结构和大小是否正确。
     */
    public function testAdd(): void
    {
        $this->assertSame("size: 0, height: 0\n", $this->tree->toString());
        $this->tree->add(10);
        $this->assertSame("size: 1, height: 1\n" .
            "1: 10 ", $this->tree->toString());
        $this->tree->add(5);
        $this->tree->add(15);
        $this->assertSame(3, $this->tree->size());
        $this->assertTrue($this->tree->contains(10));
        $this->assertTrue($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(15));
        $this->assertFalse($this->tree->contains(20));
        $this->tree->clear();
        for ($i = 0; $i < 5; $i++) {
            $this->tree->add($i);
        }
        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue($this->tree->contains($i));
        }
        $this->assertFalse($this->tree->contains(6));
        $this->assertSame("size: 5, height: 5\n" .
            "1: 0 \n" .
            "2: null 1 \n" .
            "3: null null null 2 \n" .
            "4: null null null null null null null 3 \n" .
            "5: null null null null null null null null null " .
            "null null null null null null 4 ", $this->tree->toString());
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertSame("size: 7, height: 3\n" .
            "1: 10 \n" .
            "2: 5 15 \n" .
            "3: 3 7 12 18 ", $this->tree->toString());
    }

    /**
     * 测试 remove 方法：验证删除节点后树的结构、大小及是否存在该节点。
     */
    public function testRemove(): void
    {
        // 删除空树
        $this->tree->remove(10);

        // 删除根节点
        $this->tree->add(10);
        $this->tree->remove(10);
        $this->assertSame(0, $this->tree->size());
        $this->assertTrue($this->tree->isEmpty());
        $this->assertSame("size: 0, height: 0\n", $this->tree->toString());

        // 删除重复值
        $this->tree->remove(10);

        // 删除度为0的节点
        $this->tree->clear();
        $data = [10, 5, 15];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertSame(2, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 2, height: 2\n" .
            "1: 10 \n" .
            "2: null 15 ", $this->tree->toString());

        // 删除重复值
        $this->tree->remove(5);
        $this->assertSame(2, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 2, height: 2\n" .
            "1: 10 \n" .
            "2: null 15 ", $this->tree->toString());

        $this->tree->clear();
        $data = [7, 4, 9, 2, 5];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertSame(5, $this->tree->size());
        $this->tree->remove(5);
        $this->assertSame("size: 4, height: 3\n" .
            "1: 7 \n" .
            "2: 4 9 \n" .
            "3: 2 null null null ", $this->tree->toString());

        // 删除度为1的节点
        $this->tree->clear();
        $data = [10, 5, 15, 3, 16];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertSame(4, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 4, height: 3\n" .
            "1: 10 \n" .
            "2: 3 15 \n" .
            "3: null null null 16 ", $this->tree->toString());
        $this->tree->remove(15);
        $this->assertSame(3, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 3, height: 2\n" .
            "1: 10 \n" .
            "2: 3 16 ", $this->tree->toString());

        // 删除度为2的节点
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->remove(5);
        $this->assertSame(6, $this->tree->size());
        $this->assertFalse($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(7));
        $this->assertSame("size: 6, height: 3\n" .
            "1: 10 \n" .
            "2: 3 15 \n" .
            "3: null 7 12 18 ", $this->tree->toString());
        $this->tree->remove(15);
        $this->assertSame(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 5, height: 3\n" .
            "1: 10 \n" .
            "2: 3 12 \n" .
            "3: null 7 null 18 ", $this->tree->toString());

        // 删除不存在的值
        $this->tree->remove(20);
        $this->assertSame(5, $this->tree->size());
        $this->assertFalse($this->tree->contains(15));
        $this->assertTrue($this->tree->contains(10));
        $this->assertSame("size: 5, height: 3\n" .
            "1: 10 \n" .
            "2: 3 12 \n" .
            "3: null 7 null 18 ", $this->tree->toString());
    }

    /**
     * 测试 contains 方法：验证树中是否包含指定的元素。
     */
    public function testContains(): void
    {
        $this->tree->add(10);
        $this->tree->add(5);
        $this->tree->add(15);
        $this->assertTrue($this->tree->contains(10));
        $this->assertTrue($this->tree->contains(5));
        $this->assertTrue($this->tree->contains(15));
        $this->assertFalse($this->tree->contains(20));
    }

    /**
     * 测试非递归前序遍历 preOrderNR：验证输出结果是否符合预期。
     */
    public function testPreOrderNR(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->preOrderNR($visitor);
        $this->assertSame([10, 5, 3, 7, 15, 12, 18], $visitor->getResults());
    }

    /**
     * 测试另一种非递归前序遍历 preOrderNR2：验证输出结果是否符合预期。
     */
    public function testPreOrderNR2(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->preOrderNR2($visitor);
        $this->assertSame([10, 5, 3, 7, 15, 12, 18], $visitor->getResults());
    }

    /**
     * 测试递归前序遍历 preOrder：验证输出结果是否符合预期。
     */
    public function testPreOrder(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->preOrder($visitor);
        $this->assertSame([10, 5, 3, 7, 15, 12, 18], $visitor->getResults());
    }

    /**
     * 测试非递归中序遍历 inOrderNR：验证输出结果是否符合预期。
     */
    public function testInOrderNR(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->inOrderNR($visitor);
        $this->assertSame([3, 5, 7, 10, 12, 15, 18], $visitor->getResults());
    }

    /**
     * 测试递归中序遍历 inOrder：验证输出结果是否符合预期。
     */
    public function testInOrder(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->inOrder($visitor);
        $this->assertSame([3, 5, 7, 10, 12, 15, 18], $visitor->getResults());
    }

    /**
     * 测试非递归后序遍历 postOrderNR：验证输出结果是否符合预期。
     */
    public function testPostOrderNR(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->postOrderNR($visitor);
        $this->assertSame([3, 7, 5, 12, 18, 15, 10], $visitor->getResults());
    }

    /**
     * 测试递归后序遍历 postOrder：验证输出结果是否符合预期。
     */
    public function testPostOrderTraversal(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }

        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->postOrder($visitor);
        $this->assertSame([3, 7, 5, 12, 18, 15, 10], $visitor->getResults());
    }

    /**
     * 测试层序遍历 levelOrder：验证输出结果是否符合预期。
     */
    public function testLevelOrder(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $visitor = new class extends Visitor {
            public function visit($element): bool
            {
                $this->results[] = $element;
                return false;
            }
        };
        $this->tree->levelOrder($visitor);
        $this->assertSame([10, 5, 15, 3, 7, 12, 18], $visitor->getResults());
    }

    /**
     * 测试 isComplete 方法：验证树是否为完全二叉树。
     */
    public function testIsComplete(): void
    {
        $this->assertFalse($this->tree->isComplete());
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertTrue($this->tree->isComplete());
        $this->tree->remove(5);
        $this->assertFalse($this->tree->isComplete());
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertTrue($this->tree->isComplete());
        $this->tree->add(18);
        $this->assertFalse($this->tree->isComplete());
    }

    /**
     * 测试 height 方法（非递归）：验证返回的树高度是否正确。
     */
    public function testHeight(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertSame(3, $this->tree->height());
    }

    /**
     * 测试 heightR 方法（递归）：验证返回的树高度是否正确。
     */
    public function testHeightR(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertSame(3, $this->tree->heightR());
    }

    /**
     * 测试 clear 方法：验证清空后树的状态是否正确。
     */
    public function testClear(): void
    {
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->tree->clear();
        $this->assertSame(0, $this->tree->size());
        $this->assertTrue($this->tree->isEmpty());
        $this->assertSame("size: 0, height: 0\n", $this->tree->toString());
    }

    /**
     * 测试 toString 方法：验证树的字符串表示是否正确。
     */
    public function testToString(): void
    {
        $this->assertSame("size: 0, height: 0\n", $this->tree->toString());
        $this->tree->add(2);
        $this->tree->add(1);
        $this->tree->add(3);
        $this->tree->add(4);
        $this->tree->add(5);
        $this->tree->add(6);
        $this->assertSame(
            "size: 6, height: 5\n" .
                "1: 2 \n" .
                "2: 1 3 \n" .
                "3: null null null 4 \n" .
                "4: null null null null null null null 5 \n" .
                "5: null null null null null null null null " .
                "null null null null null null null 6 ",
            $this->tree->toString()
        );
        $this->tree->clear();
        $data = [10, 5, 15, 3, 7, 12, 18];
        foreach ($data as $value) {
            $this->tree->add($value);
        }
        $this->assertSame(
            "size: 7, height: 3\n" .
                "1: 10 \n" .
                "2: 5 15 \n" .
                "3: 3 7 12 18 ",
            $this->tree->toString()
        );
    }
}
