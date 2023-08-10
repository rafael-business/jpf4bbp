(function( $ ) {
	'use strict';

	$(function() {
		$('.input-group select').addClass('custom-select');

		let table = new DataTable('#oportunities', {
			//bFilter: false,
			bLengthChange: false,
			pageLength: 5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json',
			}
		});

		$('#status-search').on('keyup', function(){
			table.search($(this).val()).draw();
	  	});

		$('#status-select').on('change', function(){
			table.columns(1).search($(this).val()).draw();
		});

		$(document).on('change', '.input-group select', (e) => {
			let status = $(e.target).val();
			let data = $(e.target).closest('.input-group');
			if ( 'trash' === status ) {
				data.find('button.send-form').html(`
					<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						<path d="M4 7l16 0" />
						<path d="M10 11l0 6" />
						<path d="M14 11l0 6" />
						<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
						<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
					</svg>
				`);
			} else {
				data.find('button.send-form').html(`
					<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						<path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
						<path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
						<path d="M14 4l0 4l-6 0l0 -4" />
					</svg>
				`);
			}
		});

		$(document).on('click', 'button.send-form', (e) => {
			let btn_html = $(e.target).html();
			$(e.target).prop('disabled', true);
			$(e.target).html(`
				<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
					<path d="M12 3a9 9 0 1 0 9 9" />
				</svg>
			`);
			$(e.target).find('svg').addClass('rotate');
			let data = $(e.target).closest('.input-group');
			let data_obj = {
				id: data.find('[name=topic_id]').eq(0).val(),
				status: data.find('select').eq(0).val()
			};
			$.ajax({
				url: wpApiSettings.root + 'jpf4bbp/change-topic-status',
				method: 'POST',
				beforeSend: function ( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
				},
				data: data_obj
			})
			.fail((err) => console.log(err.responseJSON))
			.success((res) => {
				if ( 200 === res ) {
					if ( 'trash' === data.find('select').eq(0).val() ) {
						window.location.reload();
					} else {
						$(e.target).html(`
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
								<path d="M5 12l5 5l10 -10" />
							</svg>
						`);
						setTimeout(() => {
							$(e.target).prop('disabled', false);
							$(e.target).html(btn_html);
						}, 2000);
					}
				} else {
					$(e.target).html(`
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							<path d="M18 6l-12 12" />
							<path d="M6 6l12 12" />
						</svg>
					`);
				}
			});
		});
	});

})( jQuery );
