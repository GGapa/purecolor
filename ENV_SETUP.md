# PureColor 环境配置部署指南

## 首次部署

1. **复制环境配置文件**
   ```
   cp .env.example .env
   ```

2. **编辑 .env 填入实际配置**
   ```ini
   SQL_HOST=localhost
   SQL_USERNAME=root
   SQL_PASSWORD=你的数据库密码
   SQL_DB_NAME=purecolor
   ```

3. **确保 .env 文件权限安全**
   ```bash
   chmod 600 .env
   ```

## 安全说明

- `.env` 文件已加入 `.gitignore`，不会被提交到 Git
- 不要把 `.env` 文件暴露到公开目录
- 建议设置文件权限为 600（仅所有者可读写）
- 类似 Python 的 python-dotenv 方案，敏感信息从代码中分离
