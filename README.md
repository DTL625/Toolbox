# Function Toolbox
### 介紹:
PHP函數工具包

- 陣列處理
- CSV檔案處理
- debug工具
- 數字處理
- http請求處理
- 字串處理
- URL處理
- 驗證處理

### 陣列處理

---
`get($array, $key, $def_val)` - 根據指定key獲取陣列內容  

- array: 要搜索的陣列
- key: 要查找的key
- def_val: 默認值  

		$array = [
			'a' => 1, 
			'b' => 2,
			'bar' => ['a', 'b']
		];
		// 根據指定key獲取陣列內容，$foo = 1
		$foo = Arr::get($array, 'a');
		// 支援默認值，$foo = 3
		$foo = Arr::get($array, 'c', 3);
		// 另外支援點式，$foo = a
		$foo = Arr::get($array, 'bar.0'); 




