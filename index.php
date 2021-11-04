<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	</head>
	<body>
		<div id="app">
		  {{ message }}
		</div>
		<script>
			var app = new Vue({
				el: '#app',
				data: {
					message: 'Hello to-do list!'
				}
			})
		</script>
	</body>
</html>
