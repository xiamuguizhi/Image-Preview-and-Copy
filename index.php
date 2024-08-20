<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>图片预览与复制</title>
    <style>
        .image-container {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }
        .image-container img {
            max-width: 200px;
            display: block;
            margin-bottom: 5px;
        }
        .markdown-link {
            width: 90%;
            padding: 5px;
            margin-bottom: 5px;
            text-align: center;
        }
        #unCopiedImages, #copiedImages {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>图片预览与复制</h1>

<h2>未复制的图片</h2>
<div id="unCopiedImages">
    <?php
    // 定义 img 目录路径
    $directory = __DIR__ . '/img';

    // 打开目录
    if (is_dir($directory)) {
        if ($handle = opendir($directory)) {
            // 遍历目录中的文件
            while (false !== ($file = readdir($handle))) {
                // 只处理 .jpg 文件
                if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                    // 获取文件名
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    // 图片链接保持为网络路径
                    $markdownLink = "![{$filename}](https://qq.md/img/{$file})";
                    // 输出本地图片预览及复制按钮
                    echo '
                    <div class="image-container">
                        <img src="img/' . $file . '" alt="' . $filename . '">
                        <input class="markdown-link" type="text" value="' . htmlspecialchars($markdownLink) . '" readonly>
                        <button onclick="copyToClipboard(this)">点击复制</button>
                    </div>';
                }
            }
            // 关闭目录句柄
            closedir($handle);
        }
    } else {
        echo "img 目录不存在";
    }
    ?>
</div>

<h2>已复制的图片</h2>
<div id="copiedImages"></div>

<script>
    // 复制按钮的 JavaScript 代码
    function copyToClipboard(button) {
        var input = button.previousElementSibling;
        input.select();
        input.setSelectionRange(0, 99999); // 兼容移动设备
        document.execCommand("copy");

        // 复制完成后，移动图片到已复制分组
        var imageContainer = button.parentElement;
        var copiedImages = document.getElementById("copiedImages");

        // 移动元素到已复制容器
        copiedImages.appendChild(imageContainer);

        // 修改按钮文本为已复制
        button.textContent = "已复制";
    }
</script>

</body>
</html>
