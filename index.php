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
					<span contenteditable="true" @keyup="renameTask($event, index)" @keyup.enter="addTaskAfter($event, index, task)" @keyup.delete="removeTaskBefore($event, index)">{{ task.text }}</span>
				</li>
			</ul>
		</div>

		<script>
			//TODO : fix bug happening when pressing enter at the end of the task name
			function getCaretPosition(editableDiv) {
				var caretPos = 0,
				sel, range;
				if (window.getSelection) {
					sel = window.getSelection();
					if (sel.rangeCount) {
						range = sel.getRangeAt(0);
						if (range.commonAncestorContainer.parentNode == editableDiv) {
							caretPos = range.endOffset;
						}
					}
				} else if (document.selection && document.selection.createRange) {
					range = document.selection.createRange();
					if (range.parentElement() == editableDiv) {
						var tempEl = document.createElement("span");
						editableDiv.insertBefore(tempEl, editableDiv.firstChild);
						var tempRange = range.duplicate();
						tempRange.moveToElementText(tempEl);
						tempRange.setEndPoint("EndToEnd", range);
						caretPos = tempRange.text.length;
					}
				}
				return caretPos;
			}

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
						// TODO : place cursor at the begining of new task
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
