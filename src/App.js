import React, { useState } from 'react';
//import { Link } from 'react-router-dom';
import { Link, Dialog, DialogTitle, DialogContent, DialogContentText, Button } from '@material-ui/core';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';
import './App.css';
import MaterialTable from 'material-table'


function App() {

	const [dialogOpen, setDialogOpen] = useState(false);
	const [params, setParams] = useState('');

	const columns = [
		{ title: "Athlete", field: "athlete" },
		{ title: "Age", field: "age" },
		{ title: "Country", field: "country" },
		{
			title: 'Action',
			sorting: false,
			render: rowData => <Link href={`edit-page/${rowData.id}`} target="_blank">
				<span className="material-icons MuiIcon-root" aria-hidden="true">edit</span></Link>
		}
	];

	const closePopup = () => {
		setDialogOpen(false);
	}

	const handleClose = () => {
		setDialogOpen(false);
	};

	return (
		<div className="App">
			<h1 align="center">React-App</h1>
			<h4 align='center'>Implement Server-Side Pagination, Filter, Search and Sorting in Material Table</h4>
			<MaterialTable
				title="Olympic Data"
				columns={columns}
				options={{
					debounceInterval: 700,
					padding: "dense",
					//filtering: true,
					paging: true,
					pageSize: 10,
					pageSizeOptions: [10, 20, 30],
					actionsColumnIndex: -1,
				}}
				data={query =>
					new Promise((resolve, reject) => {
						// prepare your data and then call resolve like this:
						let url = 'http://localhost/material-react-pagination/api/city_list.php?'
						//searching
						if (query.search) {
							url += `q=${query.search}`
						}
						//sorting 
						if (query.orderBy) {
							url += `&_sort=${query.orderBy.field}&_order=${query.orderDirection}`
						}
						//filtering
						if (query.filters.length) {
							const filter = query.filters.map(filter => {
								return `&${filter.column.field}${filter.operator}${filter.value}`
							})
							url += filter.join('')
						}
						//pagination
						url += `&_page=${query.page + 1}`
						url += `&_limit=${query.pageSize}`

						fetch(url).then(resp => resp.json()).then(resp => {
							//console.log(resp);
							resolve({
								data: resp.data,// your data array
								page: query.page,// current page number
								totalCount: resp.total_pages// total row number
							});
						})

					})
				}
				actions={[
					{
						icon: 'edit',
						tooltip: 'Edit Data',
						onClick: (event, rowData) => <a href={`/edit-page/${rowData.age}`}></a>
					},
					{
						icon: 'edit',
						tooltip: 'Edit Data',
						onClick: (event, rowData) => {
							setDialogOpen(true);
							setParams(rowData);
						}
					}
				]}
				localization={{
					header: {
						actions: 'Actions', //Change header name
					}
				}}
			/>

			<Dialog open={dialogOpen} onClose={handleClose} aria-labelledby="draggable-dialog-title"
				PaperProps={{
					style: {
						backgroundColor: '#c1d7fe',
						color: 'black'
					},
				}}>
				<div className="modal-size">
					<Button onClick={() => closePopup()} style={{backgroundColor: "gray", color: "white"}}>Close</Button>
					<DialogTitle id="draggable-dialog-title">Subscribe {params.id}
						<IconButton aria-label="close" onClick={handleClose} >
							<CloseIcon />
						</IconButton>
					</DialogTitle>
					<DialogContent>
						<DialogContentText>
							To subscribe to this website, please enter your email address here. We will send
							updates occasionally.
						</DialogContentText>
					</DialogContent>
				</div>
			</Dialog>
		</div>
	);
}

export default App;
