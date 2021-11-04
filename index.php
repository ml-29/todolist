<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	</head>
	<body>
		<div id="app">
			<li v-for="todo in todos">
				{{ todo.text }}
			</li>
		</div>
		<script>
			var app = new Vue({
				el: '#app',
				data: {
					todos: [
				      { text: 'Learn JavaScript' },
				      { text: 'Learn Vue' },
				      { text: 'Build something awesome' }
				    ]
				}
			})
		</script>
	</body>
</html>
