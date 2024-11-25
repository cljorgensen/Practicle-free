<?php include("./header.php") ?>
<?php
if (in_array("100001", $group_array) || in_array("100008", $group_array) || in_array("100007", $group_array)) {
} else {
	$CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<?php
$UserID = $_SESSION['id'];
$ProjectID = $_GET["projectid"];
$ProjectNameVal = getProjectNameFromID($ProjectID);
?>
<script>
	$(document).ready(function() {
		<?php initiateSimpleTrumbowyg("ProjectTaskDescription") ?>
	});
</script>

<?php
$today = new DateTime();
$today = $today->format('Y-m-d');
?>
<script>
	projectid = '<?php echo $ProjectID ?>';
	$(document).ready(function() {
		loadCalendarObject();

		function loadCalendarObject() {
			var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
				locale: 'da',
				firstDay: 1,
				contentHeight: 'auto',
				initialView: "dayGridMonth",
				headerToolbar: {
					start: 'title', // will normally be on the left. if RTL, will be on the right
					center: 'addEventButton',
					end: 'today prev,next,list' // will normally be on the right. if RTL, will be on the left
				},
				buttonText: {
					today: '<?php echo _("today") ?>',
					month: '<?php echo _("month") ?>',
					week: '<?php echo _("week") ?>',
					day: '<?php echo _("day") ?>',
					list: '<?php echo _("list") ?>'
				},
				eventDidMount: function(info) {
					$(info.el).tooltip({
						title: info.event.title,
						placement: "top",
						trigger: "hover",
						container: "body"
					});
				},
				eventClick: function(info) {
					runModalEditProjectTask(info.event.id,<?php echo $ProjectID ?>);
				},
				eventDrop: function(info) {
					var tasktitle = info.event.title;
					var taskid = info.event.id;
					var startdate = moment(info.event.start).format('YYYY-MM-DD HH:mm');
					var enddate = moment(info.event.end).format('YYYY-MM-DD HH:mm');

					if (enddate === "Invalid date") {
						message = "<?php echo _("Your tasks cannot have the exact same start and end date") ?>";
						pnotify(message, 'info');
						calendar.render();
						return;
					}

					vData = {
						taskid: taskid,
						startdate: startdate,
						enddate: enddate
					};

					$.ajax({
						type: 'GET',
						url: './getdata.php?updateProjectTaskDate',
						data: vData,
						success: function(data) {
							pnotify('Task moved', 'success');
						}
					});
					calendar.render();
				},
				customButtons: {
					addEventButton: {
						text: '<?php echo _("Add task") ?>',
						click: function() {
							runModalCreateNewProjectTask(<?php echo $ProjectID ?>);
						}
					}
				},
				selectable: true,
				editable: true,
				initialDate: '<?php echo $today ?>',
				events: [],
				views: {
					month: {
						titleFormat: {
							month: "long",
							year: "numeric"
						}
					},
					agendaWeek: {
						titleFormat: {
							month: "long",
							year: "numeric",
							day: "numeric"
						}
					},
					agendaDay: {
						titleFormat: {
							month: "long",
							year: "numeric",
							day: "numeric"
						}
					}
				}
			});

			$.ajax({
				type: 'GET',
				url: './getdata.php?getProjectTasks',
				data: {
					projectid: projectid
				},
				success: function(data) {
					obj = JSON.parse(data);
					for (var i = 0; i < obj.length; i++) {
						CalTaskID = obj[i].TaskID;
						CalTitle = obj[i].TaskName;
						CalStart = obj[i].CalStart;
						CalEnd = obj[i].CalEnd;
						calendar.addEvent({
							id: CalTaskID,
							title: CalTitle,
							start: CalStart,
							end: CalEnd
						});
					}
				}
			});
			calendar.render();
		};
	});
</script>
<div class="container-fluid py-4">
	<div class="row">
		<div class="col-12 ms-auto">
			<div class="d-flex mb-4">
				<i class="fas fa-project-diagram fa-lg"></i> <a href="projects_view.php?projectid=<?php echo $ProjectID; ?>"> <?php echo _($ProjectNameVal); ?></a>
				<div class="pe-4 mt-1 position-relative ms-auto">
					<p class="text-secondary text-sm mb-2"><?php echo _("Team members") ?></p>
					<div class="d-flex align-items-center justify-content-center">
						<div class="avatar-group" id="teamavatargroup">
							<script>
								var projectid = '<?php echo $ProjectID ?>';

								$.ajax({
									type: 'GET',
									url: './getdata.php?getProjectTeamMembers',
									data: {
										projectid: projectid
									},
									success: function(data) {
										obj = JSON.parse(data);
										for (var i = 0; i < obj.length; i++) {
											var UserID = obj[i].UserID;
											var FullName = obj[i].FullName;
											var Email = obj[i].Email;
											var ProfilePicture = obj[i].ProfilePicture;
											const el = document.createElement('a');
											profileurl = "user_profile.php?userid=" + UserID;
											el.setAttribute('href', profileurl);
											el.setAttribute('title', FullName);
											el.setAttribute('data-bs-toggle', 'tooltip');
											el.classList.add('avatar', 'avatar-sm', 'rounded-circle');
											el.innerHTML = "<img alt = 'Image placeholder 'src='./uploads/images/profilepictures/" + ProfilePicture + "' class='rounded-circle'>";
											const box = document.getElementById('teamavatargroup');
											box.appendChild(el);
										}
									}
								});
							</script>
						</div>
					</div>
					<hr class="vertical dark mt-0">
				</div>
				<div class="ps-4">
					<button class="btn btn-outline-dark btn-icon-only mb-0 mt-3" data-bs-toggle="modal" data-target="#new-board-modal">
						<i class="material-icons text-sm font-weight-bold">
							add
						</i>
					</button>
				</div>
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card card-calendar">
				<div class="card-body p-3">
					<div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Kanban scripts -->
<script src="./assets/js/plugins/fullcalendar.min.js"></script>

<?php include("./footer.php") ?>