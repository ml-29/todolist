<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
		<script src="https://kit.fontawesome.com/739b8fcf94.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div id="app">
			<li v-for="todo in todos">
				<span><i class="far fa-square"></i></span><span>{{ todo.text }}</span>
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
