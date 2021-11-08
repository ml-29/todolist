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
					<span class="task-edit" contenteditable="true" @keyup.enter="addTaskAfter($event, index, task)" @keyup.delete="removeTaskBefore($event, index)" @keyup="renameTask($event, index)">{{ task.text }}</span>
				</li>
			</ul>
		</div>

		<script>
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

			//BUG : pressing suppr while editing doesn't do anything

			function moveCursor(elem, index){
				if(elem != null && index != null) {
					if(elem.createTextRange) {
						var range = elem.createTextRange();
						range.move('character', caretPos);
						range.select();
					}
					else {
						if(elem.selectionStart) {
							elem.focus();
							elem.setSelectionRange(caretPos, caretPos);
						}else{
							elem.focus();
						}
					}
				}
			}

			const app = Vue.createApp({
				data() {
					return {
						tasks : [
							{ text: 'Learn JavaScript', done : false },
							{ text: 'Learn Vue', done : true },
							{ text: 'Build something awesome', done : false}
						],
						cursorPos : {
							taskIndex : null,
							charAt : null
						}
					}
				},
				updated(){
					var tEl = document.getElementsByClassName('task-edit');
					moveCursor(tEl[this.cursorPos.taskIndex], this.cursorPos.charAt);
				},
				methods : {
					addTaskAfter(evt, index, task){
						var t = evt.target.innerText.split('\n', 2);
						this.tasks[index].text = t[0].replace('\n','');
						evt.target.innerText = t[0].replace('\n','');
						this.tasks.splice(index + 1, 0, {text : t[1].replace('\n','') , done : false});
						//set info to place cursor at the begining of new task on next render
						this.cursorPos.taskIndex = index + 1;
						this.cursorPos.charAt = 0;
						// TODO : place cursor at the begining of new task
					},
					removeTaskBefore(evt, index){
						// if there's nothing before cursor and there's a task before the current one
						// var i = index - 1;
						// var b = getCaretPosition(evt.target);
						// if(i > 0 && b.length == 0){
						// 	this.tasks.splice(i, 1);
						// }
					},
					renameTask(evt, index){
						this.tasks[index].text = evt.target.innerText;
						// this.moveCursor(evt.target, evt.target.innerText.length);
						console.log(evt.target.innerText);
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
