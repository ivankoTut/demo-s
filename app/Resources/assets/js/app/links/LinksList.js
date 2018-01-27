import React, {Component} from 'react';
import Link from './Link';

import axios from 'axios';

export default class LinksList extends Component {
    constructor(props) {
        super(props);
        this.state = {links: []};
    }

    componentDidMount() {

        axios.get('/api/link').then(response => {
            this.setState({links: response.data});
        }).catch(error => {
            console.log(error);
        })
    }

    render() {

        return (
            <table className="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Full link</th>
                    <th>Short link</th>
                    <th>Count visit</th>
                    <th>Link</th>
                </tr>
                </thead>
                <tbody>
                    {
                        this.state.links.map(function(item){
                            return <Link key={item.id} link={item} />
                        })
                    }
                </tbody>
            </table>
        );
    }
}