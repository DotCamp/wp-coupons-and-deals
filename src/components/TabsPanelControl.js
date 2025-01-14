import { TabPanel } from "@wordpress/components";

function TabsPanelControl({
  normalStateLabel,
  hoverStateLabel,
  normalState,
  hoverState,
}) {
  return (
    <TabPanel
      className="wpcd-tab-panels"
      tabs={[
        {
          name: "normalState",
          title: normalStateLabel,
        },
        {
          name: "hoverState",
          title: hoverStateLabel,
        },
      ]}
    >
      {(tab) => (tab.name === "normalState" ? normalState : hoverState)}
    </TabPanel>
  );
}
export default TabsPanelControl;
