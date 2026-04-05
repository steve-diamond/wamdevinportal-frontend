import React from 'react';
import { BarChart, Bar, XAxis, YAxis } from 'recharts';

const data = [
  { name: 'Users', value: 100 },
  { name: 'Events', value: 20 },
  { name: 'Resources', value: 50 }
];

const ChartsPanel = () => (
  <BarChart width={300} height={200} data={data}>
    <XAxis dataKey="name" />
    <YAxis />
    <Bar dataKey="value" />
  </BarChart>
);

export default ChartsPanel;
