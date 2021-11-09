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
			<!-- <div id="lists">
				<ul>
					<li v-for="(list, index) in lists" @click="displayList(index)">{{list.name}}</li>
				</ul>
			</div>
			<div id="list">
				<b>{{lists[list].name}}</b>
				<ul>
					<li v-for="(task, index) in tasks" :key="index">
						<i @click="task.done = !task.done" v-bind:class="{ 'far fa-square': !task.done, 'far fa-check-square': task.done }"></i>
						<input class="task-edit" v-model="task.text" @keyup.enter="onEnter($event.target.value, $event.target.selectionStart, $event.target.selectionEnd, index)" @keyup.delete="onDelete($event.target.selectionStart, index, $event.target.value)" type="text" name="task-edit">
					</li>
				</ul>
			</div> -->
			<list-list></list-list>
		</div>

		<script>
			var sampleLists = [
				{
					name : 'Next week',
					tasks : [
						{ text: 'Do the laundry', done : false },
						{ text: 'Take out the trash', done : false },
						{ text: 'Bring cat to the vet', done : false },
						{ text: 'Bake Christmas cookies', done : false },
						{ text: 'Call Mrs Sanderson back', done : false },
						{ text: 'Repair car', done : false}
					]
				},
				{
					name : 'Programming',
					tasks : [
						{ text: 'Learn JavaScript', done : false },
						{ text: 'Learn Vue', done : true },
						{ text: 'Order last O\'Reilly\'s book', done : false}
					]
				},
				{
					name : 'Christmas shopping',
					tasks : [
						{ text: 'Pretty socks for Joe', done : false },
						{ text: 'Birds are rad (book) for Sam', done : true },
						{ text: 'History of Mechanics (book) for Mom', done : false}
					]
				},
				{
					name : 'Teas I want to try',
					tasks : [
						{ text: 'Oolong', done : false },
						{ text: 'Christmas tea', done : true },
						{ text: 'Halloween tea', done : true },
						{ text: 'Rooibos', done : true }
					]
				},
			];
			function moveCursor(elem, index){
				if(elem != null && index != null) {
					if(elem.createTextRange) {
						var range = elem.createTextRange();
						range.move('character', index);
						range.select();
					}
					else {
						if(elem.selectionStart) {
							elem.focus();
							elem.setSelectionRange(index, index);
						}else{
							elem.focus();
						}
					}
				}
			}

			const app = Vue.createApp({});

			// left panel containing all the lists
			app.component('list-list', {
				data(){
					return {
						lists : sampleLists,
						displayed : 0,
					};
				},
				methods : {
					displayList(index){
						this.displayed = index;
					}
				},
				template : `<div id="lists">
				<ul>
						<li v-for="(list, index) in lists" @click="displayList(index)">{{list.name}}</li>
					</ul>
				</div>
				<list v-bind:list="lists[displayed]"></list>`
			});

			// single list view (right panel with list name and tasks)
			app.component('list', {
				props: ['list'],
				data() {
					return {
						// list : sampleLists[index],
						cursor : {
							task : null,
							char : null
						}
					}
				},
				updated(){
					var tEl = document.getElementsByClassName('task-edit');
					moveCursor(tEl[this.cursor.task], this.cursor.char);
				},
				template : `<div id="list">
					<b>{{list. name}}</b>
					<ul>
						<li v-for="(task, index) in list.tasks" :key="index">
							<i @click="task.done = !task.done" v-bind:class="{ 'far fa-square': !task.done, 'far fa-check-square': task.done }"></i>
							<input class="task-edit" v-bind:value="task.text" @keyup.enter="onEnter($event.target.value, $event.target.selectionStart, $event.target.selectionEnd, index)" @keyup.delete="onDelete($event.target.selectionStart, index, $event.target.value)" type="text" name="task-edit">
						</li>
					</ul>
				</div>`,
				methods : {
					onEnter(value, selstart, selend, index){
						//set cursor position for next update
						this.cursor.task = index + 1;
						this.cursor.char = 0;

						var t1 = value.substring(0, selstart);
						var t2 = value.substring(selend);
						this.list.tasks[index].text = t1;
						this.list.tasks.splice(index + 1, 0, {text : t2 , done : false});
					},
					onDelete(selstart, index, value){
						if(selstart == 0 && index != 0){
							//set cursor position for next update
							this.cursor.task = index - 1;
							this.cursor.char = this.list.tasks[index - 1].text.length;

							this.list.tasks[index - 1].text += value;
							this.list.tasks.splice(index, 1);
						}
					}
					// ,
					// displayList(index){
					// 	this.list = index;
					// }
				}
			});

			app.mount('#todo-list');
		</script>
		<style>
			ul li {
				list-style: none;
			}
			ul {
				padding : 0;
			}
			input {border:0;outline:0;}
			input:focus {outline:none!important;}
			#todo-list {
				display: flex;
				width: 350px;
			}
			#lists {
				width: 50%;
				border-right: 2px solid Black;
			}
			i, #lists li {
				cursor: pointer;
			}
			#lists li:hover {
				background-color: #eee;
			}
			#list {
				margin-left: 10px;
			}
		</style>
	</body>
</html>
