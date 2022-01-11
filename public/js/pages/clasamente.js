	let clClasament = []

	if (window.innerWidth > 900){
		clClasament = [
			{ label: 'Loc', dataField: 'Position', width: '5%' },
			{ label: 'Sportiv', dataField: 'Person', width: '55%' },
			{ label: 'Categorie', dataField: 'Category', width: '10%' },
			{ label: 'Team', dataField: 'Team', width: '20%' },
			{ label: 'Procent', dataField: 'Procent', width: '10%' },
		]
	}else{
		clClasament = [
			{ label: 'Loc', dataField: 'Position', width: '5%' },
			{ label: 'Sportiv', dataField: 'Person', width: '55%' },
			{ label: 'Categorie', dataField: 'Category', width: '10%' },
			{ label: 'Procent', dataField: 'Procent', width: '20%' },
		]
	}


	Smart('#gridclasament2021', class {
		get properties() {
			return {
				dataSource: new Smart.DataAdapter(
				{
					dataSource: dsClasament2021,
					dataFields:
					[
						'Position: number',
						'Person: string',
						'Category: string',
						'Team: string',
						'Procent: number'
					]
				}),
				sorting: {
					enabled: true
				},
				filtering: {
					enabled: true
				},
				behavior: { columnResizeMode: 'growAndShrink' },
				columns: clClasament
			}
		}
	});
	   
	