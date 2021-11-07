<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://unpkg.com/vue@next"></script>
		<script src="https://kit.fontawesome.com/739b8fcf94.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div id="todo-list">
			<ul>
				<li v-for="(task, index) in tasks" :key="index">
					<i @click="task.done = !task.done" v-bind:class="{ 'far fa-square': !task.done, 'far fa-check-square': task.done }"></i>
					<span contenteditable="true" @keyup="renameTask($event, index)" @keyup.enter="addTaskAfter($event, index, task)">{{ task.text }}</span>
				</li>
			</ul>
		</div>

		<script>
			const app = Vue.createApp({
				data() {
					return {
						tasks : [
							{ text: 'Learn JavaScript', done : false },
							{ text: 'Learn Vue', done : true },
							{ text: 'Build something awesome', done : false}
						]
					}
				},
				methods : {
					addTaskAfter(evt, index, task){
						var t = evt.target.innerText.split('\n');
						task.text = t[0];
						this.tasks.splice(index + 1, 0, {text : t[1], done : false});
					},
					renameTask(evt, index){
						this.tasks[index].text = evt.target.innerText;
					}
				}
			});

			app.mount('#todo-list');
		</script>
		<style>
			ul li {
				list-style: none;
			}
		</style>
	</body>
</html>
