@extends('layouts.main_layout')

@section('title', 'Viewing Exam')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<div id="title">
				<h2>Exam: {{$exam->exam_name}}</h2>
				<h5>{{$exam->exam_description}}</h5>
				<input type="hidden" id="examNameVal" value="{{$exam->exam_name}}">
				<input type="hidden" id="examDescriptionVal" value="{{$exam->exam_description}}">
			</div>

			<div class="row">
				<div class="col-md-6">
					<a href="{{route('exams index')}}"><i class="fas fa-arrow-left"></i> Back</a>
				</div>
                <div class="col-md-6" style="display:flex;flex-direction:column;align-items:flex-end;">
                    <a href="#" class="no-border" style="display:inline-block;" id="editExamGroupBtn"><i class="fas fa-object-group"></i><small>{{$exam->group ? '('.$exam->group->title.')' : ''}}</small> Edit Group</a>
					<a href="#" class="no-border" style="display:inline-block;" id="editExamBtn"><i class="fas fa-edit"></i> Edit</a>
				</div>
			</div>
		</div>
	</div>

	@if($exam->hasMissingCorrectAnswers())
		<div class="alert alert-warning" style="margin-top: 10px;"><i class="fas fa-exclamation-circle"></i> {{$exam->hasMissingCorrectAnswers()}} questions without correct answers.</div>
	@endif

	<hr>

	<div class="row">
		<div id="questions-container">
			<div id="questions" class="col-md-12">
				@if(count($exam->questions))
				<h6>Questions ({{count($exam->questions)}}):</h6>
					<ul>
						@foreach($exam_questions as $question)
							<li>
								<a href="{{route('exam view question', [$exam->id, $question->id])}}">
									{{$question->quiz_question}}
									@if(count($question->answers) && !$question->answers->where('correct_answer', 1)->first())<span style="color: orange;"><i class="fas fa-exclamation-circle"></i> No correct answer!</span>
									@elseif(!count($question->answers))
										<span style="color: orange;"><i class="fas fa-exclamation-circle"></i> No associated answers!</span>
									@endif
								</a>
							</li>
						@endforeach
					</ul>

					{{$exam_questions->links()}}
					<small>Showing {{($exam_questions->currentpage()-1)*$exam_questions->perpage()+1}} to {{$exam_questions->currentpage()*$exam_questions->perpage()}} of  {{$exam_questions->total()}} entries</small>
				@else
					<p style="margin:0;">You have not created any questions.</a></p>
				@endif
			</div>
		</div>
	</div>

	<hr>

	<div id="buttons">
		<button type="button" class="btn btn-primary" id="addQuestionBtn">Add Question <i class="fas fa-plus"></i></button>
    </div>

    <div class="modal" id="editGroupsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Exam Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{$exam->group ? 'Current Group: '.$exam->group->title : ''}}</p>
                <select class="form-control" name="groups" id="groups">
                    <option value="0" id="group-0">No Group</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveExamGroupBtn">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

@endsection

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
        function loadGroups(groups) {
            var groups;

            $.getJSON('/api/groups/all', function(data) {
                groups = data;
            }).done(function () {
                var options = [];

                $.each(groups, function(key, val) {
                    options.push('<option id="group-'+val.id+'" value="'+val.id+'">'+val.title+'</option>')
                });

                $('#groups').append(options);
            });
        }

		$(document).ready(function () {

            loadGroups();

			$(document).on('click', '#editExamBtn', function () {
				$('#editExamBtn').hide();
				$('#title').html('\
					<input type="text" class="form-control" value="'+$("#examNameVal").val()+'" id="examName" placeholder="Exam Title" />\
					<textarea class="form-control" placeholder="Exam Description" id="examDescription">'+$("#examDescriptionVal").val()+'</textarea>\
					<button class="btn btn-outline-info" id="cancelEditExam"><i class="fas fa-times"></i> Cancel</button>\
					<button class="btn btn-success" id="saveEditExam">Save Details <i class="fas fa-save"></i></button>\
					');
			});

			$(document).on('click', '#cancelEditExam', function () {
				$('#title').load(window.location + ' #title');
				$('#editExamBtn').show();
			});

            $(document).on('click', '#editExamGroupBtn', function () {
                $('#editGroupsModal').modal('show');
            });

            $(document).on('click', '#saveExamGroupBtn', function () {
                var selectedGroup = $('#groups').val();

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
                $.ajax({
                    url: "/api/exams/update/group",
                    method: 'post',
                    data: {
                        exam: {{$exam->id}},
                        group: selectedGroup
                    },
                    success: function () {
                        $('#editGroupsModal').modal('show');
                        alert('Updated Group');
                    }
                });
            });

			$(document).on('click', '#saveEditExam', function () {
				$(this).attr('disabled', true);
				$(this).html('Please wait..');

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{route('exams update')}}",
					method: 'post',
					data: {
						exam_id: {{$exam->id}},
						exam_name: $('#examName').val(),
						exam_description: $('#examDescription').val()
					},
					success: function () {
						$('#title').load(window.location + ' #title');
						$('#editExamBtn').show();
					}
				});
			});

			$(document).on('click', '#addQuestionBtn', function () {
				$(this).hide();
				$('#buttons').append('\
					<input type="text" class="form-control" style="margin-bottom:10px;" name="quiz_question" id="quizQuestion" placeholder="Enter Question.." autocomplete="off" />\
					<button type="button" class="btn btn-success" id="submitAddQuestionBtn">Submit</button>\
					<button type="button" class="btn btn-outline-info" id="cancelAddQuestionBtn">Cancel</button>\
					');
			});

			$(document).on('click', '#cancelAddQuestionBtn', function () {
				$(this).remove();
				$('#submitAddQuestionBtn').remove();
				$('#quizQuestion').remove();
				$('#addQuestionBtn').show();
			});

			$(document).on('click', '#submitAddQuestionBtn', function () {
				$(this).attr('disabled', true);
				$(this).html('Please Wait..');

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{route('exam add question')}}",
					method: 'post',
					data: {
						exam_id: {{$exam->id}},
						quiz_question: $('#quizQuestion').val()
					},
					success: function () {
						$('#submitAddQuestionBtn').remove();
						$('#quizQuestion').remove();
						$('#questions-container').load(location.href + ' #questions');
						$('#addQuestionBtn').show();
						$('#cancelAddQuestionBtn').remove();
					}
				});
			});

		});
	</script>

@endsection
