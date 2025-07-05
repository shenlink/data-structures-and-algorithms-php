<?php

declare(strict_types=1);

namespace Shenlink\Algorithms\Tree;

use SplStack;
use SplQueue;


/**
 * 二叉树基类
 */
class BinaryTree
{
    /**
     * 二叉树的节点总数
     */
    protected int $size = 0;

    /**
     * 二叉树的根节点
     */
    protected ?Node $root = null;

    /**
     * 前序遍历的非递归实现
     * 整个流程：
     * 1. 创建一个栈，将根节点入栈
     * 2. 当栈非空时，将栈顶节点出栈，并访问该节点
     * 3. 如果该节点有右子节点，则将右子节点入栈
     * 4. 如果该节点有左子节点，则将左子节点入栈
     * 5. 如果栈不为空，回到步骤2
     * 为什么这样就可以前序遍历二叉树了？
     * 首先，前序遍历是先访问根节点，然后访问一路访问左子结点，之后访问右子结点
     * 首先，先入栈根节点，之后，弹出一个节点node，访问该节点，第一次循环时，
     * 这个节点是根节点，符合前序遍历的要求，然后，入栈该节点的右子节点，左子节点，
     * 先入栈右子节点，再入栈左子节点，这样，栈顶的节点就是左子节点，
     * 进入下一轮循环的时候，弹出的节点node就是之前压入栈的左子节点，符合要求，
     * 然后，继续压入右子节点和左子结点，这样，栈顶的节点就是左子节点，
     * 重复这个循环，直到达到了树的最左边，也就是中序遍历的第一个节点时，压入栈，
     * 此时，弹出栈的时候，弹出的节点就是中序遍历的第一个节点，符合要求，
     * 然后，继续弹出节点node，这个节点时中序遍历的第一个节点的兄弟节点，如果
     * 这个兄弟节点还有左右子节点的话，那就一起入栈，重复循环，没有的话，那就是
     * 一路返回，持续访问根节点的左子树的右侧的节点。一路返回到了根节点的右子节点时，
     * 压入左子结点和右子节点，重复循环
     * 从上面可以看出来，这是一个重复的操作
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function preOrderNR(?Visitor $visitor): void
    {
        if ($this->root === null || $visitor === null) {
            return;
        }

        $stack = new SplStack();
        $stack->push($this->root);
        $node = null;
        while (!$stack->isEmpty()) {
            $node = $stack->pop();
            if ($visitor->visit($node->element) || $visitor->stop) {
                return;
            }
            if ($node->right !== null) {
                $stack->push($node->right);
            }
            if ($node->left !== null) {
                $stack->push($node->left);
            }
        }
    }

    /**
     * 前序遍历的第2种非递归实现
     * 这个的思路与上一个方法的preOrderNR的思路类似
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function preOrderNR2(?Visitor $visitor): void
    {
        if ($this->root === null || $visitor === null) {
            return;
        }

        $stack = new SplStack();
        $node = $this->root;
        while (true) {
            if ($node !== null) {
                if ($visitor->visit($node->element) || $visitor->stop) {
                    return;
                }
                if ($node->right !== null) {
                    $stack->push($node->right);
                }
                $node = $node->left;
            } else if ($stack->isEmpty()) {
                break;
            } else {
                $node = $stack->pop();
            }
        }
    }

    /**
     * 前序遍历
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function preOrder(?Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }
        $this->preOrderRecursive($this->root, $visitor);
    }

    /**
     * 前序遍历的递归方法
     * 首先要搞清楚什么是递归？
     * 递归，就是方法自己调用自己，直到满足条件，不再调用自己，返回结果。
     * 但是一般而言，每次递归，都要解决比上次的问题更小的问题，直到最后，
     * 可以直接求出问题的解。
     * 从这里可以看出来，递归的关键是要逐步地分解问题成小问题，上一层的
     * 问题的解依赖下一层问题的解，并在最后一次分解中直接求出问题的解。
     * 为什么这样能够实现树的前序遍历？
     * 首先：树是一个递归结构，对于一棵树来说，可以分为根节点，左子树和右子树，
     * 对于左子树和右子树，也可以分为根节点，左子树和右子树，那这样，树就是
     * 一个嵌套的结构，也可以理解为一个递归结构。
     * 当我们在写递归方法时，要从宏观的语义出发，不要陷入递归的微观语义和细节，
     * 递归的微观语义和细节是让我们验证递归的，一开始就想到这些反而会阻碍我们
     * 写出递归代码。
     * 对于以下递归代码，首先，递归的终止条件是node == null，如果一开始
     * 的node节点就是null，那么就直接结束。
     * 如果是递归左子树到中序遍历的第一个节点，那么也递归终止，如果递归
     * 右子树到中序遍历的最后的一个节点，那么递归也终止。
     * 从递归的宏观语义出发，我们只需要关注递归的终止条件，以及递归的调用，
     * 首先，我们先访问node节点，第一次调用的时候，访问的是根节点，然后
     * 然后访问根节点的左子树，右子树，由于树是一个嵌套的递归结构，所以
     * 访问左子树和右子树的代码设计为递归调用，就可以访问完整棵树了。
     * 可以看到，这个递归代码，每次递归，都是在分解问题，从根节点的左子树
     * 和右子树，到根节点的左子树的左子树和右子树，这是一个不断分解问题成
     * 小问题的过程，知道最后一个小问题，也就是node == null，这时，可以
     * 直接解决，也就是返回
     * 因为递归是上一层问题的解是依赖下一层的问题的解的，所以，递归回溯的
     * 过程中，问题从小到大，依次得到了解决
     *
     * @param ?Node $node 要遍历的起始节点
     * @param Visitor $visitor 访问器
     */
    protected function preOrderRecursive(?Node $node, Visitor $visitor): void
    {
        if ($node === null || $visitor->stop) {
            return;
        }
        $visitor->stop = $visitor->visit($node->element);
        $this->preOrderRecursive($node->left, $visitor);
        $this->preOrderRecursive($node->right, $visitor);
    }

    /**
     * 中序遍历的非递归实现
     * 中序遍历：先访问左子树，然后访问根节点，最后访问右子树
     * 这是一个循环
     * 首先，入栈根节点node，然后一直入栈node.left，然后，弹出，访问，
     * 就是访问的中序遍历的第一个节点，之后，node = node.right，
     * 看右子树还有没有，有的话，重复循环操作，没有的话，弹出栈顶节点node，‘
     * 这个节点就是中序遍历的第二个节点，然后node = node.right，此时，
     * 会入栈这个节点，在下一轮节点访问，这样，句访问完了中序遍历的第一个，
     * 第二个和第三个节点，之后，就是循环操作了
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function inOrderNR(?Visitor $visitor): void
    {
        if ($this->root === null || $visitor === null) {
            return;
        }

        $stack = new SplStack();
        $node = $this->root;
        while (true) {
            if ($node !== null) {
                $stack->push($node);
                $node = $node->left;
            } else if ($stack->isEmpty()) {
                break;
            } else {
                $node = $stack->pop();
                if ($visitor->visit($node->element) || $visitor->stop) {
                    return;
                }
                $node = $node->right;
            }
        }
    }

    /**
     * 中序遍历
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function inOrder(?Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }
        $this->inOrderRecursive($this->root, $visitor);
    }

    /**
     * 中序遍历的递归方法
     * 同前序遍历preOrder，不再赘述
     *
     * @param ?Node $node 要遍历的起始节点
     * @param Visitor $visitor 访问器
     */
    protected function inOrderRecursive(?Node $node, Visitor $visitor): void
    {
        if ($node === null || $visitor->stop) {
            return;
        }

        $this->inOrderRecursive($node->left, $visitor);
        if ($visitor->stop) {
            return;
        }
        $visitor->stop = $visitor->visit($node->element);
        $this->inOrderRecursive($node->right, $visitor);
    }

    /**
     * 后序遍历的非递归实现
     * 使用一个栈来辅助遍历，从根节点开始入栈。
     * 利用指针 prev 记录上一个访问的节点，用于判断当前节点是否可以访问。
     * 当栈顶节点是叶子节点或其子节点已被访问过时，才访问该节点。
     * 否则，先将右子节点入栈，再将左子节点入栈，以保证左子节点先被处理。
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function postOrderNR(?Visitor $visitor): void
    {
        if ($this->root === null || $visitor === null) {
            return;
        }

        $stack = new SplStack();
        $stack->push($this->root);
        $prev = null;
        $top = null;
        while (!$stack->isEmpty()) {
            $top = $stack->top();
            if ($top->isLeaf() || ($prev !== null && $prev->parent === $top)) {
                $prev = $stack->pop();
                if ($visitor->visit($prev->element) || $visitor->stop) {
                    return;
                }
            } else {
                if ($top->right !== null) {
                    $stack->push($top->right);
                }
                if ($top->left !== null) {
                    $stack->push($top->left);
                }
            }
        }
    }

    /**
     * 后序遍历
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function postOrder(?Visitor $visitor): void
    {
        if ($visitor === null) {
            return;
        }
        $this->postOrderRecursive($this->root, $visitor);
    }

    /**
     * 后序遍历的递归方法
     * 同前序遍历preOrder，不再赘述
     *
     * @param ?Node $node 要遍历的起始节点
     * @param Visitor $visitor 访问器
     */
    protected function postOrderRecursive(?Node $node, Visitor $visitor): void
    {
        if ($node === null || $visitor->stop) {
            return;
        }

        $this->postOrderRecursive($node->left, $visitor);
        $this->postOrderRecursive($node->right, $visitor);
        if ($visitor->stop) {
            return;
        }
        $visitor->stop = $visitor->visit($node->element);
    }

    /**
     * 层序遍历
     * 
     * @param ?Visitor $visitor 访问器
     */
    public function levelOrder(?Visitor $visitor): void
    {
        if ($this->root === null || $visitor === null) {
            return;
        }

        $queue = new SplQueue();
        $queue->enqueue($this->root);
        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();
            if ($visitor->visit($node->element) || $visitor->stop) {
                return;
            }
            if ($node->left !== null) {
                $queue->enqueue($node->left);
            }
            if ($node->right !== null) {
                $queue->enqueue($node->right);
            }
        }
    }

    /**
     * 判断树是否为完全二叉树
     * 除了最后一层之外，完全二叉树的每一层都被完全填满。
     * 最后一层的节点都集中在该层的最左边，且该层的节点数量可以从左至右排列，
     * 允许不满，但要求节点位置紧凑，即所有的空缺出现在最右侧。
     *
     * @return bool 如果是完全二叉树返回 true，否则返回 false
     */
    public function isComplete(): bool
    {
        if ($this->root === null) {
            return false;
        }
        $queue = new SplQueue();
        $queue->enqueue($this->root);
        $leaf = false;
        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();
            if ($leaf && !$node->isLeaf()) {
                return false;
            }
            if ($node->left !== null) {
                $queue->enqueue($node->left);
            } else {
                $leaf = true;
                if ($node->right !== null) {
                    return false;
                }
            }
            if ($node->right !== null) {
                $queue->enqueue($node->right);
            } else {
                $leaf = true;
            }
        }

        return true;
    }

    /**
     * 获取树的高度（使用层序遍历）
     *
     * @return int 返回树的高度
     */
    public function height(): int
    {
        if ($this->root === null) {
            return 0;
        }

        $height = 0;
        $levelSize = 1;
        $queue = new SplQueue();
        $queue->enqueue($this->root);
        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();
            $levelSize--;
            if ($node->left !== null) {
                $queue->enqueue($node->left);
            }
            if ($node->right !== null) {
                $queue->enqueue($node->right);
            }
            if ($levelSize === 0) {
                $levelSize = $queue->count();
                $height++;
            }
        }
        return $height;
    }

    /**
     * 获取树的高度（使用递归）
     *
     * @return int 返回树的高度
     */
    public function heightR(): int
    {
        return $this->levelHeight($this->root);
    }

    /**
     * 获取树的高度（使用递归）
     * 这个递归操作为什么成立？
     * 首先，只有一个根节点，高度是1
     * 如果节点为空，返回高度为0
     * 所以，递归获取左子树的高度的时候，是分解大问题为小问题，
     * 大问题：左子树的高度是多少？
     * 小问题：左子树的更小的左子树的高度是多少？
     * 通过递归不断分解小问题，会遇到递归终止条件，当节点为空时，返回高度为0
     * 所以，可以由小问题反推回大问题，也就是左子树的高度
     * 同理，获取右子树的高度，
     * 两个高度取最大值，加上根节点的高度，就是树的高度了
     *
     * @param ?Node $node 要计算高度的起始节点
     * @return int 返回指定节点为根的子树的高度
     */
    protected function levelHeight(?Node $node): int
    {
        if ($node === null) {
            return 0;
        }
        return 1 + max($this->levelHeight($node->left), $this->levelHeight($node->right));
    }

    /**
     * 清空二叉搜索树
     */
    public function clear(): void
    {
        $this->root = null;
        $this->size = 0;
    }

    /**
     * 获取二叉搜索树的节点个数
     *
     * @return int 返回二叉树的节点个数
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * 判断二叉搜索树是否为空
     *
     * @return bool 如果为空返回 true，否则返回 false
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * 创建节点
     *
     * @param int $element 节点要存储的元素
     * @param ?Node $parent 父节点
     * @return Node 返回创建的新节点
     */
    protected function createNode(int $element, ?Node $parent): Node
    {
        return new Node($element, $parent);
    }

    /**
     * 查找节点的前驱节点
     * 1. 首先，先看该节点有没有左子节点，有，看有没有右子节点，没有，那左子节点
     * 就是该节点的前驱节点，有右子节点，那一路往右子节点右边下探，
     * 直到遇到null，此时，最后一个非null的节点就是该节点的前驱节点
     * 2. 如果没有左子节点，获取该节点的父节点，如果该节点的父节点为null，
     * 则该节点没有前驱节点，如果该节点的父节点不为null，则判断该节点是不是
     * 父节点的左子节点，是，那就一路往上找，直到找到一个节点node，
     * node是父节点的右子节点，此时，node.parent就是该节点的前驱节点
     *
     * @param Node $node 要查找前驱的节点
     * @return ?Node 返回指定节点的前驱节点
     */
    protected function predecessor(Node $node): ?Node
    {
        $prev = $node->left;
        if ($prev !== null) {
            while ($prev->right !== null) {
                $prev = $prev->right;
            }
            return $prev;
        }
        while ($node->parent !== null && $node === $node->parent->left) {
            $node = $node->parent;
        }
        return $node->parent;
    }

    /**
     * 查找节点的后继节点
     * 1. 首先，先看该节点有没有右子节点，有，看有没有左子节点，没有，那右子节点
     * 就是该节点的后继节点，有左子节点，那一路往左子节点左边下探，
     * 直到遇到null，此时，最后一个非null的节点就是该节点的后继节点
     * 2. 如果没有右子节点，获取该节点的父节点，如果该节点的父节点为null，
     * 则该节点没有后继节点，如果该节点的父节点不为null，则判断该节点是不是
     * 父节点的右子节点，是，那就一路往上找，直到找到一个节点node，
     * node是父节点的左子节点，此时，node.parent就是该节点的后继节点
     *
     * @param Node $node 要查找后继的节点
     * @return ?Node 返回指定节点的后继节点
     */
    protected function successor(Node $node): ?Node
    {
        $next = $node->right;
        if ($next !== null) {
            while ($next->left !== null) {
                $next = $next->left;
            }
            return $next;
        }
        while ($node->parent !== null && $node === $node->parent->right) {
            $node = $node->parent;
        }
        return $node->parent;
    }

    /**
     * 返回动态数组的字符串表示
     *
     * @return string 表示动态数组内容的字符串
     */
    public function toString(): string
    {
        $stringBuilder = '';
        $treeHeight = $this->height();
        $stringBuilder .= "size: {$this->size}, height: {$treeHeight}\n";
        if ($this->root === null) {
            return $stringBuilder;
        }
        $queue = new SplQueue();
        $queue->enqueue($this->root);
        $height = 1;
        $levelSize = 1;
        $stringBuilder .= "{$height}: ";
        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();
            $elementStr = $node->element === null ? "null" : (string)$node->element;
            $stringBuilder .= "{$elementStr} ";
            $levelSize--;
            if ($node->left !== null) {
                $queue->enqueue($node->left);
            } else {
                $queue->enqueue(new Node(null, null));
            }
            if ($node->right !== null) {
                $queue->enqueue($node->right);
            } else {
                $queue->enqueue(new Node(null, null));
            }
            if ($levelSize === 0) {
                $levelSize = $queue->count();
                $height++;
                if ($height > $treeHeight) {
                    break;
                }
                if ($levelSize > 0) {
                    $stringBuilder .= "\n{$height}: ";
                }
            }
        }
        return $stringBuilder;
    }
}
