import { TabPanel } from "@wordpress/components";

function TabsPanelControl({ tabs }) {
  return (
    <TabPanel className="wpcd-tab-panels" tabs={tabs}>
      {(tab) => tab.component}
    </TabPanel>
  );
}
export default TabsPanelControl;
