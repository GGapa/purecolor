<!-- This file is temporarily disabled. There is seemingly having some problems in it. -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>编辑色板 — 纯·色</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="css/style.css" type='text/css' rel='stylesheet'>
    <script src="js/vue.js"></script>
    <style>
        /* ===== Edit Page Enhancements ===== */
        .edit-page-body {
            background: #FFFBFE;
            min-height: 100vh;
        }

        .edit-header {
            background: var(--color);
            color: #fff;
            padding: 20px 24px;
            margin: 0 -10px 30px;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .edit-header h1 {
            font-size: 24px;
            font-weight: 500;
            margin: 0;
            letter-spacing: 0.15px;
        }

        .edit-header .edit-subtitle {
            font-size: 14px;
            opacity: 0.75;
            margin-top: 4px;
        }

        .edit-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 16px 100px;
        }

        .edit-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(var(--color-rgb), 0.10);
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .edit-card-title {
            font-size: 16px;
            font-weight: 500;
            color: var(--color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .edit-card-title .material-symbols-outlined {
            font-size: 22px;
        }

        .form-field {
            margin-bottom: 16px;
        }

        .form-field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #49454F;
            margin-bottom: 6px;
            letter-spacing: 0.25px;
        }

        .form-field input[type="text"],
        .form-field textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #CAC4D0;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background: #fff;
            color: #1D1B20;
        }

        .form-field input[type="text"]:focus,
        .form-field textarea:focus {
            border-color: var(--color);
            box-shadow: 0 0 0 3px rgba(var(--color-rgb), 0.12);
        }

        .form-field input[type="text"].input-error,
        .form-field textarea.input-error {
            border-color: #B3261E;
            box-shadow: 0 0 0 3px rgba(179, 38, 30, 0.10);
        }

        .form-field .field-hint {
            font-size: 12px;
            color: #79747E;
            margin-top: 4px;
        }

        .form-field .char-count {
            font-size: 12px;
            color: #79747E;
            text-align: right;
            margin-top: 2px;
        }

        .form-field .char-count.near-limit {
            color: #B3261E;
        }

        /* Theme color field with preview */
        .theme-color-field {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .theme-color-field input[type="text"] {
            flex: 1;
        }

        .theme-color-preview {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 1px solid #CAC4D0;
            flex-shrink: 0;
            transition: background-color 0.3s ease;
        }

        /* Group editor */
        .group-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid rgba(var(--color-rgb), 0.10);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            position: relative;
        }

        .group-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .group-card-header input.group-title-input {
            flex: 1;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 18px;
            font-weight: 500;
            padding: 8px 0;
            outline: none;
            background: transparent;
            color: #1D1B20;
            transition: border-color 0.2s ease;
        }

        .group-card-header input.group-title-input:focus {
            border-bottom-color: var(--color);
        }

        .group-card-header .group-actions {
            display: flex;
            gap: 4px;
        }

        .group-card-header .group-actions button {
            background: transparent;
            border: none;
            color: #79747E;
            padding: 6px 8px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .group-card-header .group-actions button:hover {
            background: rgba(var(--color-rgb), 0.08);
            color: var(--color);
        }

        .group-card-header .group-actions button:disabled {
            opacity: 0.3;
            cursor: default;
        }

        .group-card-header .group-actions button.group-delete-btn:hover {
            background: rgba(179, 38, 30, 0.08);
            color: #B3261E;
        }

        /* Color item editor (Material) */
        .color-item-edit-material {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: background 0.2s ease;
        }

        .color-item-edit-material:hover {
            background: rgba(0,0,0,0.03);
        }

        .color-swatch {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            flex-shrink: 0;
            border: 1px solid rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .color-swatch:hover {
            transform: scale(1.08);
        }

        .color-item-edit-material input[type="text"] {
            border: none;
            border-bottom: 1px solid transparent;
            font-size: 14px;
            padding: 6px 4px;
            outline: none;
            background: transparent;
            transition: border-color 0.2s ease;
            color: #1D1B20;
        }

        .color-item-edit-material input[type="text"]:focus {
            border-bottom-color: var(--color);
        }

        .color-item-edit-material input.color-hex-input {
            width: 110px;
            font-family: 'Roboto Mono', monospace;
            text-transform: uppercase;
        }

        .color-item-edit-material input.color-name-input {
            flex: 1;
            min-width: 0;
        }

        .color-item-edit-material input[type="text"].input-error {
            border-bottom-color: #B3261E;
        }

        .color-item-actions {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }

        .color-item-actions button {
            background: transparent;
            border: none;
            color: #79747E;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .color-item-actions button:hover:not(:disabled) {
            background: rgba(var(--color-rgb), 0.08);
            color: var(--color);
        }

        .color-item-actions button:disabled {
            opacity: 0.25;
            cursor: default;
        }

        .color-item-actions button.color-delete-btn:hover:not(:disabled) {
            background: rgba(179, 38, 30, 0.08);
            color: #B3261E;
        }

        /* Add buttons */
        .add-color-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 12px;
            border: 2px dashed #CAC4D0;
            border-radius: 12px;
            background: transparent;
            color: #79747E;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .add-color-btn:hover {
            border-color: var(--color);
            color: var(--color);
            background: rgba(var(--color-rgb), 0.04);
        }

        .add-color-btn .material-symbols-outlined {
            font-size: 20px;
        }

        .add-group-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 16px;
            border: 2px dashed rgba(var(--color-rgb), 0.25);
            border-radius: 16px;
            background: transparent;
            color: var(--color);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 24px;
        }

        .add-group-btn:hover {
            border-color: var(--color);
            background: rgba(var(--color-rgb), 0.04);
        }

        .add-group-btn .material-symbols-outlined {
            font-size: 24px;
        }

        /* Submit button (Material FAB style) */
        .submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 16px;
            background: var(--color);
            color: #fff;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(var(--color-rgb), 0.30);
            transition: all 0.25s ease;
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            box-shadow: 0 5px 16px rgba(var(--color-rgb), 0.40);
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: scale(0.98);
            box-shadow: 0 2px 6px rgba(var(--color-rgb), 0.25);
        }

        .submit-btn.sending {
            pointer-events: none;
            opacity: 0.7;
        }

        .submit-btn .material-symbols-outlined {
            font-size: 22px;
        }

        /* Error message */
        .error-panel {
            background: #FFDAD6;
            color: #B3261E;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 1.6;
            display: none;
        }

        .error-panel.show {
            display: block;
        }

        .error-panel ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        /* Auto-sort toggle */
        .auto-sort-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: rgba(var(--color-rgb), 0.06);
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #49454F;
            margin-bottom: 12px;
            user-select: none;
            transition: background 0.2s ease;
        }

        .auto-sort-toggle:hover {
            background: rgba(var(--color-rgb), 0.10);
        }

        .auto-sort-toggle input {
            display: none;
        }

        .auto-sort-toggle .toggle-track {
            width: 36px;
            height: 20px;
            border-radius: 10px;
            background: #CAC4D0;
            position: relative;
            transition: background 0.25s ease;
        }

        .auto-sort-toggle input:checked + .toggle-track {
            background: var(--color);
        }

        .auto-sort-toggle .toggle-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .auto-sort-toggle input:checked + .toggle-track .toggle-thumb {
            transform: translateX(16px);
        }

        /* Transitions */
        .color-item-transition {
            transition: all 0.3s ease;
        }
        .color-item-transition-enter,
        .color-item-transition-leave-to {
            opacity: 0;
            transform: translateX(-10px);
        }
        .color-item-transition-leave-active {
            position: absolute;
        }

        .group-card-transition {
            transition: all 0.4s ease;
        }
        .group-card-transition-enter,
        .group-card-transition-leave-to {
            opacity: 0;
            transform: translateY(20px);
        }

        /* Mobile adjustments */
        @media screen and (max-width: 600px) {
            .edit-header h1 {
                font-size: 20px;
            }

            .edit-card {
                padding: 16px;
            }

            .color-hex-input {
                width: 90px !important;
            }

            .theme-color-field {
                flex-wrap: wrap;
            }

            .group-card-header {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body class="edit-page-body">
    <style id="now_color_definition">
        :root{
            --color: #5e72e4;
            --color-rgb: 94, 114, 228;
        }
    </style>
    <script>
        var editing_id = 0;
    </script>

    <div id="app">
        <div class="edit-header">
            <h1>{{id == 0 ? "新建色板" : "基于该色板新建"}}</h1>
            <div class="edit-subtitle">{{title == "" ? "纯 · 色" : title}}</div>
        </div>

        <div class="edit-form">
            <!-- Error panel -->
            <div class="error-panel" :class="{show: errors.length > 0}" v-if="errors.length > 0">
                <strong>请修正以下问题：</strong>
                <ul>
                    <li v-for="err in errors">{{ err }}</li>
                </ul>
            </div>

            <!-- Palette info card -->
            <div class="edit-card">
                <div class="edit-card-title">
                    <span class="material-symbols-outlined">info</span>
                    色板信息
                </div>
                <div class="form-field">
                    <label>名称</label>
                    <input type="text" maxlength="100" autocomplete="off" v-model="title" placeholder="给你的色板起个名字" />
                </div>
                <div class="form-field">
                    <label>作者</label>
                    <input type="text" maxlength="50" autocomplete="off" v-model="author" placeholder="你的名字" />
                </div>
                <div class="form-field">
                    <label>介绍</label>
                    <textarea rows="3" maxlength="5000" v-model="description" placeholder="简单介绍一下这个色板（可选）" style="resize: none;"></textarea>
                    <div class="char-count" :class="{'near-limit': description.length > 4500}">{{ description.length }}/5000</div>
                </div>
                <div class="form-field">
                    <label>主题色</label>
                    <div class="theme-color-field">
                        <input type="text" maxlength="7" autocomplete="off" v-model.lazy="color" :class="{'input-error': !vcheckhex(color)}" v-on:change="color = vtofullhex(color)" placeholder="#5e72e4" />
                        <div class="theme-color-preview" :style="'background-color: ' + (vcheckhex(color) ? color : '#5e72e4')"></div>
                    </div>
                    <div class="field-hint">进入色卡页面时的默认颜色</div>
                </div>
            </div>

            <!-- Color groups -->
            <transition-group name="group-card-transition" tag="div">
                <div v-for="(group, index) in list" class="group-card" :key="group.key">
                    <div class="group-card-header">
                        <input class="group-title-input" placeholder="分组标题" autocomplete="off" v-model="group.name" />
                        <div class="group-actions">
                            <button @click="moveupgroup(index)" :disabled="index == 0" title="上移分组">
                                <span class="material-symbols-outlined" style="font-size:18px;">arrow_upward</span>
                            </button>
                            <button @click="movedowngroup(index)" :disabled="index == list.length - 1" title="下移分组">
                                <span class="material-symbols-outlined" style="font-size:18px;">arrow_downward</span>
                            </button>
                            <button class="group-delete-btn" @click="removegroup(index)" title="删除分组">
                                <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                            </button>
                        </div>
                    </div>

                    <!-- Auto sort toggle -->
                    <label class="auto-sort-toggle" v-if="group.colors.length > 1">
                        <input type="checkbox" v-model="group.autosort" />
                        <span class="toggle-track"><span class="toggle-thumb"></span></span>
                        <span>按色相自动排序</span>
                    </label>

                    <transition-group name="color-item-transition" tag="div">
                        <div v-for="item in sorted(group.colors, group.autosort)" class="color-item-edit-material" :key="item.key">
                            <div class="color-swatch" :style="'background-color: ' + item.hex" :title="item.hex"></div>
                            <input type="text" class="color-hex-input" placeholder="#000000" maxlength="7" autocomplete="off" v-model="item.hex" :class="{'input-error': !vcheckhex(item.hex)}" v-on:change="item.hex = vtofullhex(item.hex)" />
                            <input type="text" class="color-name-input" placeholder="颜色名称" autocomplete="off" v-model="item.name" />
                            <div class="color-item-actions">
                                <button @click="moveupcolor(group.colors, group.colors.indexOf(item))" :disabled="group.colors.indexOf(item) == 0" title="上移">
                                    <span class="material-symbols-outlined" style="font-size:18px;">keyboard_arrow_up</span>
                                </button>
                                <button @click="movedowncolor(group.colors, group.colors.indexOf(item))" :disabled="group.colors.indexOf(item) == group.colors.length - 1" title="下移">
                                    <span class="material-symbols-outlined" style="font-size:18px;">keyboard_arrow_down</span>
                                </button>
                                <button class="color-delete-btn" @click="removecolor(group.colors, group.colors.indexOf(item))" title="删除">
                                    <span class="material-symbols-outlined" style="font-size:18px;">close</span>
                                </button>
                            </div>
                        </div>
                        <button class="add-color-btn" @click="addcolor(index)" :key="'add-' + group.key">
                            <span class="material-symbols-outlined">add</span>
                            添加颜色
                        </button>
                    </transition-group>
                </div>
            </transition-group>

            <button class="add-group-btn" @click="addgroup">
                <span class="material-symbols-outlined">add_box</span>
                添加分组
            </button>

            <button class="submit-btn" :class="{sending: submitting}" @click="submit">
                <span class="material-symbols-outlined" v-if="!submitting">publish</span>
                <span class="material-symbols-outlined" v-else class="spin-icon">refresh</span>
                <span>{{ submitting ? '发布中...' : '发布色板' }}</span>
            </button>
        </div>

        <form id="form" action="submit.php" method="POST" style="display: none;">
            <input name="title" v-model="title"/>
            <textarea name="description" v-model="description"></textarea>
            <input name="author" v-model="author"/>
            <input name="themecolor" v-model="color"/>
            <textarea name="color_json" v-html="JSON.stringify(list)"></textarea>
        </form>

        <div id="mask2"></div>
    </div>

    <script src="js/main.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                color: '#5e72e4',
                id: editing_id,
                list: [],
                title: '',
                author: '',
                description: '',
                errors: [],
                submitting: false
            },
            watch: {
                color: function (newcolor) {
                    if (!checkhex(newcolor)){
                        newcolor = "#5e72e4";
                    }
                    $("#now_color_definition").html(":root{--color: " + newcolor + "; --color-rgb: " + hex2str(newcolor) + ";}");
                }
            },
            methods: {
                vcheckhex: function(hex){ return checkhex(hex); },
                vtofullhex: function(hex){ return tofullhex(hex); },
                vhex2gray: function(hex){ return hex2gray(hex); },

                addgroup: function(){
                    this.list.push({
                        "name": "",
                        "colors": [],
                        "autosort": false,
                        "key": randomfrom(1, 999999999)
                    });
                },
                moveupgroup: function(index){
                    this.list[index] = this.list.splice(index - 1, 1, this.list[index])[0];
                },
                movedowngroup: function(index){
                    this.list[index] = this.list.splice(index + 1, 1, this.list[index])[0];
                },
                removegroup: function(index){
                    if (this.list.length <= 1 && this.list[0].colors.length === 0) {
                        this.list.splice(index, 1);
                        return;
                    }
                    if (confirm('确定要删除这个分组吗？')) {
                        this.list.splice(index, 1);
                    }
                },
                addcolor: function(groupid){
                    this.list[groupid].colors.push({
                        "hex": getrandomcolor_except_toolight(),
                        "name": "",
                        "key": randomfrom(1, 999999999)
                    });
                },
                removecolor: function(colors, index){
                    colors.splice(index, 1);
                },
                moveupcolor: function(colors, index){
                    colors[index] = colors.splice(index - 1, 1, colors[index])[0];
                },
                movedowncolor: function(colors, index){
                    colors[index] = colors.splice(index + 1, 1, colors[index])[0];
                },
                sorted: function(colors, autosort) {
                    if (!autosort) return colors;
                    return colors.slice().sort(function(a, b) {
                        if (a.hex == "subtitle" || b.hex == "subtitle") return 0;
                        let hsl1 = rgb2hsl(hex2rgb(a.hex).R, hex2rgb(a.hex).G, hex2rgb(a.hex).B);
                        let hsl2 = rgb2hsl(hex2rgb(b.hex).R, hex2rgb(b.hex).G, hex2rgb(b.hex).B);
                        return hsl1['h'] - hsl2['h'];
                    });
                },
                submit: function(){
                    var self = this;
                    self.errors = [];

                    if (self.title.trim().length === 0) {
                        self.errors.push('请填写色板名称');
                    }
                    if (self.author.trim().length === 0) {
                        self.errors.push('请填写作者名称');
                    }
                    if (!checkhex(self.color)) {
                        self.errors.push('请填写正确的主题色值（格式如 #5e72e4）');
                    }
                    if (self.list.length === 0) {
                        self.errors.push('请至少新建一个分组');
                    }
                    for (var i = 0; i < self.list.length; i++) {
                        if (self.list[i].colors.length === 0) {
                            self.errors.push('每个分组中至少需要有一个颜色');
                            break;
                        }
                    }
                    for (var i = 0; i < self.list.length; i++) {
                        for (var j = 0; j < self.list[i].colors.length; j++) {
                            if (!checkhex(self.list[i].colors[j].hex)) {
                                self.errors.push('请检查第' + (i+1) + '个分组中的色值是否正确');
                                break;
                            }
                        }
                    }

                    if (self.errors.length > 0) return;

                    self.submitting = true;
                    setTimeout(function(){
                        $.ajax({
                            url: "submit.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                title: self.title,
                                description: self.description,
                                author: self.author,
                                themecolor: self.color,
                                color_json: JSON.stringify(self.list)
                            },
                            success: function(result){
                                self.submitting = false;
                                if (result.status == "failed") {
                                    self.errors = [result.msg];
                                } else {
                                    window.location.href = "p/" + result.id;
                                }
                            },
                            error: function(){
                                self.submitting = false;
                                self.errors = ['发布失败，请检查网络连接后重试'];
                            }
                        });
                    }, 400);
                }
            }
        });

        // Add keyboard shortcut: Ctrl+S to save
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                app.submit();
            }
        });
    </script>

    <!-- Hidden legacy elements -->
    <div id="head-edit" style="display:none;">
        <div id="title" class="editpage-title">
            <span id="subtitle">Pure Colors</span>
        </div>
    </div>
    <div id="content-edit" style="display:none;"></div>
</body>
</html>
