<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://unpkg.com/vue@next"></script>
		<script src="https://kit.fontawesome.com/739b8fcf94.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div id="list-rendering">
			<ul>
				<li v-for="todo in todos">
					<i @click="todo.done = !todo.done" v-bind:class="{ 'far fa-square': !todo.done, 'far fa-check-square': todo.done }"></i>
					<span contenteditable="true" @keyup="onEdit">{{ todo.text }}</span>
				</li>
			</ul>
		</div>

		<script>
			const ListRendering = {
				data() {
					return {
						todos: [
							{ text: 'Learn JavaScript', done : false },
							{ text: 'Learn Vue', done : true },
							{ text: 'Build something awesome', done : false }
						]
					}
				},
				methods:{
					onEdit(evt){
						var src = evt.target.innerText;
						this.text = src;
					}
				}
			};
			Vue.createApp(ListRendering).mount('#list-rendering');
		</script>
		<style>
			ul li {
				list-style: none;
			}
		</style>
	</body>
</html>
