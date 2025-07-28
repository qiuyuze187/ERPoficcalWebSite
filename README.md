# ERPoficcalWebSite
A Website can tell people something,and can change its text

欢迎查看ERP宣传网页源代码！

没有任何盈利目的，只是想把网站源码共享，供大家参考学习

你可以在此汇报网站的Bug，设计错误等问题，也可以提一些建议，我会积极采纳大家的建议。

本网页使用HTML和PHP两种语言，HTML为宣传网页，PHP为管理网页（管理网页还不完善）

# 如何部署？

如果你用WindowsServer，可以安装IIS（不需要管理网页），或PHP（需要管理网页）

Linux可以使用：

apt install php

来安装PHP以及依赖组件

当然，我开发时用WindowsServer环境测试，Linux暂未测试，所以如果部署到Linux上有问题，可以讨论，毕竟我比较习惯Windows。

# input.txt如何编辑：

如果是标题/需要强调的内容，用：

Title:

做标识

正文可直接写入

图片资源会根据后缀（.jpg/.png/.gif）自动识别，无需标识图片

# notice.txt文件说明：

公告内容，可编辑

注意：notice无内容请不要删除，可能会出现问题。

手机版的内容引用电脑版的资源文件

# .htaccess文件：

如果你部署在Apache服务器上，会自动调转到error.html，其他服务器可以参加他们的说明文档。

祝你在部署和体验过程中愉快！
