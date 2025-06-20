# PHP 数据结构与算法

本项目是一个基于 PHP 实现的 **数据结构与算法** 示例库，旨在帮助开发者更好地理解常见数据结构与算法的实现原理。

## 📚 简介

本项目旨在提供清晰、规范的 PHP 实现代码，涵盖常见的数据结构和算法。每个实现都包含详细的注释说明、单元测试。

> 每个实现都位于 `src/` 目录下，并在 `tests/` 目录 中包含完整的单元测试用例。

## 🛠️ 安装与使用

### 环境要求
- PHP ^7.4
- Composer 2.8.6

### 安装步骤
1. 克隆项目到本地：

- gitee
```shell
git clone https://gitee.com/shenlink/data-structures-and-algorithms-php.git
cd data-structures-and-algorithms-php
```

- github
```shell
git clone https://github.com/shenlink/data-structures-and-algorithms-php.git
cd data-structures-and-algorithms-php
```

2. 下载依赖：
```shell
composer install
```

3. 配置自动加载：

本项目采用 Composer 的 PSR-4 自动加载方式，所有类文件都在 `src/` 目录下。

```json
"autoload": {
    "psr-4": {
        "Shenlink\\Algorithms\\": "src/"
    }
}
```

运行以下命令更新自动加载：

```bash
composer dump-autoload
```

## 🧪 测试

本项目使用 PHPUnit 编写单元测试，你可以通过以下命令运行测试：

```bash
php shenlink test
```

或者使用 Composer 提供的快捷命令：

```bash
composer test
```

## 📄 许可证

本项目采用 [MIT 许可证](LICENSE)