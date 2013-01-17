Pop PHP Framework
=================

Documentation : Cli
-------------------

命令行界面（CLI）的组成部分，是一个非常有用的组件，它允许你执行一些有用的任务，如：

* 评估目前的环境所需的依赖
* 安装一个项目，从项目的安装文件
* 设置应用程序的默认语言
* 创建一个类图
* 重新配置项目已移至
* 检查当前版本对最新版本

<pre>
script/pop --check                     // Check the current configuration for required dependencies
script/pop --help                      // Display this help
script/pop --install file.php          // Install a project based on the install file specified
script/pop --lang fr                   // Set the default language for the project
script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
script/pop --reconfig projectfolder    // Reconfigure the project based on the new location of the project
script/pop --show                      // Show project install instructions
script/pop --version                   // Display version of Pop PHP Framework and latest available
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
