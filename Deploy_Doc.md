# 部署文档

介绍如何安装本系统

### 系统和环境需求

    CentOS 7 / 8 
    PHP <7.4
    MYSQL 5.6 / 8.0

### 软件需求

    ffmpeg (系统系统bin目录)
    screen (不间断loop转码队列)

### 目录结构
      /tmp/logs  转码日志
      /upload/original 上传的源视频文件
      /cloud/日期/ 转码后输出的文件

### 输出格式
      .mp4 视频文件
      hls/ HLS/m3u8文件
      slide.jpg 视频单列图
      preview.gif 视频动态预览图
      mozaique.jpg 视频九宫格预览图

### 安装流程

   1. 首先将本系统上传至网站根目录
   2. 配置伪静态
   
        APACHE 伪静态
        ```apacheconf
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
        ```
        
        Nginx 伪静态
        ```nginx
            location / {
                try_files $uri $uri/ /index.php;
            }
        ```
   3. 新建 MYSQL 数据库,导入 sql/system.sql 
   4. 修改 config.php 的数据库配置 (包括 主机/数据库名称/密码)
   5. 访问域名登录 默认账户 ADMIN 密码 XXOO (在config.php中修改)
   6. 进入后台上传视频进行
   7. 终端进入根目录运行 php bin/c2mp4 查看输出
   
###  转码进程的运行
(因为当年一切期望简单化,所以直接使用的无限循环方式来读取数据库队列进行转码)

利用screen实现后端不间断运行命令
```apacheconf

screen -dmS transcoding

# 在新的Screen窗口中运行

cd 网站根目录;  # 修改下
while true; do
php bin/c2mp4
sleep 1;
done`

```
然后按 `Ctrl + A + D ` 退出 screen 的窗口 (服务器重启前命令都在运行)

如果希望重新进入这个窗口,观察运行情况, 执行 `screen -r transcoding` 即可进入
如果提示错误,运行 `screen -list` 看下是不是有多个transcoding的窗口
更多可以学习下 screen 软件的相关命令
这里就不解释更多了
