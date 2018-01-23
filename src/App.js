import React, { Component } from 'react';
import './App.css';
import Axios from 'axios';

import ReactTable from "react-table";
import "react-table/react-table.css";

class App extends Component {
  constructor() {
    super();
    this.state = {
      data: [],
      pages: -1,
      loading: false
    };
  }

  render() {
    return (
      <div className={'table-list'}>
        <ReactTable
          columns={[

                {
                  Header: "Artist",
                  accessor: "artist"
                },
                {
                  Header: "Song",
                  accessor: "song"
                },
                {
                  Header: "Genre",
                  accessor: "genre"
                },
                {
                  Header: "Year",
                  accessor: "year"
                }
              ]
            }
          defaultPageSize={10}
          className="-striped -highlight"

          data={this.state.data} // should default to []
          pages={this.state.pages} // should default to -1 (which means we don't know how many pages we have)
          loading={this.state.loading}
          manual // informs React Table that you'll be handling sorting and pagination server-side
          filterable
          onFetchData={(state, instance) => {
            // show the loading overlay
            this.setState({loading: true});
            // fetch your data
            Axios.post('http://localhost:8000/tracks', {
              page: state.page,
              pageSize: state.pageSize,
              sorted: state.sorted,
              filtered: state.filtered
            })
              .then((res) => {
                // Update react-table
                this.setState({
                  data: res.data.tracks,
                  pages: res.data.pages,
                  loading: false
                })
              })
          }}
        />
        <br/>
        <Tips/>
      </div>
    );
  }
}

export const Tips = () =>
  <div style={{ textAlign: "center" }}>
    <em>Tip: Hold shift when sorting to multi-sort!</em>
  </div>;


export default App;
