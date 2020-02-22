import React from 'react';
import axios from 'axios';
import { Button, Container, Segment, Tab, Icon } from 'semantic-ui-react';
import styled from 'styled-components';
import { useHistory } from 'react-router-dom';

import TabPopular from '../templates/TabPopular';
import TabNew from '../templates/TabNew';

const Home = () => {
  const history = useHistory();

  const panes = [
    {
      menuItem: '　　　人気順　　　',
      render: () => (
        <Tab.Pane key="tabPopular" attached={false}>
          <TabPopular />
        </Tab.Pane>
      ),
    },
    {
      menuItem: '　　　新着順　　　',
      render: () => (
        <Tab.Pane key="tabNew" attached={false}>
          <TabNew />
        </Tab.Pane>
      ),
    },
  ];

  const onClickApi = () => {
    axios
      .get(`${process.env.REACT_APP_API_URL}/sample`)
      .then(res => console.log(res.data))
      .catch(err => console.log(err));
  };
  const onClickToPost = () => history.push('/post');

  return (
    <>
      <SCbodyContainer>
        <Button animated="fade" fluid color="black" onClick={onClickToPost}>
          <Button.Content visible>
            <Icon name="pencil" />
            ブラックストーリーを投稿する
          </Button.Content>
          <Button.Content hidden>(ｏﾟДﾟ)＝◯)`3゜)∵</Button.Content>
        </Button>
        <Segment raised textAlign="center">
          <SCmenuContainer>
            <Tab menu={{ pointing: true, secondary: true, color: 'teal' }} panes={panes} />
          </SCmenuContainer>
        </Segment>
      </SCbodyContainer>
      <Button color="green" style={{ width: '200px', height: '80px' }} onClick={onClickApi}>
        <span style={{ fontSize: '1.4rem' }}>API実行</span>
      </Button>
    </>
  );
};

const SCbodyContainer = styled(Container)`
  margin-top: 16px;
  margin-bottom: 16px;
`;

const SCmenuContainer = styled.div`
  .ui {
    justify-content: center;
    .active {
      background-color: '#00796B' !important;
    }
  }
`;

export default Home;