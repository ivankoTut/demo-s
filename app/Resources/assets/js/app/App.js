import React, { Component } from 'react';
import LinkForm from './LinkForm';


class App extends Component {
    render() {
        return (
            <div className="container-fluid">
                <h2 className="text-center">The service of short links</h2>

                <div className="row">
                    <LinkForm />
                </div>
            </div>
        );
    }
}

export default App;